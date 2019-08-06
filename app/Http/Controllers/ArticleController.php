<?php


namespace App\Http\Controllers;


use App\Models\LocalArticle;
use App\Models\URL;
use Illuminate\Support\Facades\Redis;

class ArticleController
{
    public function show($id)
    {
        $article = LocalArticle::query()
            ->where('id', $id)
            ->first()
            ->toArray();
        [$result, $response] = $this->viewPowerBefore($article);

        if ($result === false) {
            return $response;
        }
        [$mode, $viewResponse] = $this->viewAssemble($article);

        if ($mode === 'template') {
            // 模板模式优先
            return $viewResponse;
        }
        return view('articles.index', [
            'article' => $article,
            'content' => $viewResponse ?? $article['content']
        ]);
    }

    /**
     * 显示文章之前一些基本的权限认证
     *
     * @param $article
     * @return array
     */
    public function viewPowerBefore($article)
    {
        if (!is_null($article['right_now'])) {
            ///todo 立即跳转
            return [false, view('jump', [
                'right_now' => $article['right_now']
            ])];
        }

        if ($article['source_check'] == LocalArticle::OPEN && $article['is_jump'] === LocalArticle::MAINDOMAIN || $article['is_jump'] === LocalArticle::TWODOMAIN) {
            //来源检测 确定是否是A链接跳转过来的
            $ref = $_SERVER['HTTP_REFERER'] ?? null;
            $path = parse_url($ref)['path'] ?? null;
            if (strpos($path, 'A-url') === false) {
                return [false, view('jump', [
                    'right_now' => 'https://www.qq.com/'
                ])];
            }
        }

        if ($article['is_wechat'] == LocalArticle::OPEN) {
            //todo  检查是否是微信浏览器访问
            $userAgent = request()->header('user-agent');
            if (strpos($userAgent, 'MicroMessenger') === false) {
                //不是微信浏览器
                return [false, view('jump', [
                    'right_now' => 'https://www.qq.com/'
                ])];
            }
        }

        if ($article['form'] == LocalArticle::OPEN) {
            //利用表单提交进行跳转隐藏源代码
            $is_get = request()->isMethod('get');
            if ($is_get == true) {
                $currentURL = url()->current();
                if (strpos($currentURL, 'iframe') !== false) {
                    // ifram访问 特殊处理
                    return [true, true];
                }
                //第一次访问
                $url = URL::B($article['user_id']);
                return [false, view('articles.assembly.formJump', [
                    'url' => $url,
                    'articleId' => $article['id'],
                ])];
            } else {
                //post提交再次返回
                return [true, true];
            }

        }

        return [true, true];
    }

    /**
     * 视图拼装
     *
     * @param $article
     * @return array
     */
    public function viewAssemble($article)
    {
        $currentURL = url()->current();
        if ($article['is_encryption'] == LocalArticle::OPEN && $article['is_vue'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {
            if (strpos($currentURL, 'iframe') !== false) {
                // ifram访问 特殊处理
                $view = view('articles.assembly.content', [
                    'article' => $article,
                    'content' => view('articles.assembly.vue'),
                ]);
                $view = base64_encode($view);
                return ['template', view('articles.template.ifram_encryp_vue.encryp_vue', [
                    'result' => $view,
                    'article' => $article,
                ])];
            } else {
                return ['template', view('articles.template.ifram_encryp_vue.index',
                    [
                        'url' => URL::B($article['user_id']) . '/iframe/' . $article['id'],
                        'article' => $article
                    ])];
            }
        }
        if ($article['is_encryption'] == LocalArticle::OPEN && $article['is_ajax'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {
            // ifram访问 特殊处理
            if (strpos($currentURL, 'iframe') !== false) {
                // ifram访问 特殊处理
                $view = view('articles.assembly.content', [
                    'article' => $article,
                    'content' => view('articles.assembly.AjaxArticle', [
                        'id' => $article['id']
                    ]),
                ]);
                $view = base64_encode($view);
                return ['template', view('articles.template.ifram_encryp_ajax.encryp_ajax', [
                    'result' => $view,
                    'article' => $article,
                ])];
            } else {
                return ['template', view('articles.template.ifram_encryp_ajax.index',
                    [
                        'url' => URL::B($article['user_id']) . '/iframe/' . $article['id'],
                        'article' => $article
                    ])];
            }
        }

        if ($article['is_encryption'] == LocalArticle::OPEN && $article['is_ajax'] == LocalArticle::OPEN) {
            $content = view('articles.template.encryp_ajax.encryp', [
                'article' => $article,
                'content' => view('articles.assembly.AjaxArticle', [
                    'id' => $article['id']
                ])
            ]);
            $content = base64_encode($content);
            return ['template', view('articles.template.encryp_ajax.index', [
                'content' => $content,
                'article' => $article,
            ])];
        }

        if ($article['is_encryption'] == LocalArticle::OPEN && $article['is_vue'] == LocalArticle::OPEN) {

            $content = view('articles.template.encryp_vue.encryp', [
                'article' => $article,
                'content' => view('articles.assembly.vue')
            ]);
            $content = base64_encode($content);
            return ['template', view('articles.template.encryp_vue.index', [
                'content' => $content,
                'article' => $article,
            ])];
        }

        if ($article['is_encryption'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {

            if (strpos($currentURL, 'iframe') !== false) {
                // ifram访问 特殊处理
                $view = view('articles.assembly.content', [
                    'article' => $article,
                    'content' => $article['content'],
                ]);
                $view = base64_encode($view);
                return ['template', view('articles.template.encryp_iframe.encryp', [
                    'result' => $view,
                    'article' => $article,
                ])];
            } else {
                return ['template', view('articles.template.encryp_iframe.index',
                    [
                        'url' => URL::B($article['user_id']) . '/iframe/' . $article['id'],
                        'article' => $article
                    ])];
            }
        }

        if ($article['is_vue'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {
            if (strpos($currentURL, 'iframe') !== false) {
                // ifram访问 特殊处理
                $view = view('articles.assembly.content', [
                    'article' => $article,
                    'content' => view('articles.assembly.vue'),
                ]);
                return ['template', view('articles.template.vue_iframe.vue', [
                    'content' => $view,
                    'article' => $article
                ])];
            } else {
                return ['template', view('articles.template.vue_iframe.index',
                    [
                        'url' => URL::B($article['user_id']) . '/iframe/' . $article['id'],
                        'article' => $article
                    ])];
            }
        }
        if ($article['is_ajax'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {
            if (strpos($currentURL, 'iframe') !== false) {
                // ifram访问 特殊处理
                $view = view('articles.assembly.content', [
                    'article' => $article,
                    'content' => view('articles.assembly.AjaxArticle', [
                        'id' => $article['id']
                    ]),
                ]);
                return ['template', view('articles.template.ajax_iframe.ajax', [
                    'content' => $view,
                    'article' => $article
                ])];
            } else {
                return ['template', view('articles.template.ajax_iframe.index',
                    [
                        'url' => URL::B($article['user_id']) . '/iframe/' . $article['id'],
                        'article' => $article
                    ])];
            }
        }

        if ($article['is_encryption'] == LocalArticle::OPEN) {
            return ['single', view('articles.assembly.encryptionArticle', [
                'content' => base64_encode($article['content'])
            ])];
        }
        if ($article['is_vue'] == LocalArticle::OPEN) {
            return ['single', view('articles.assembly.vue')];
        }
        if ($article['is_ajax'] == LocalArticle::OPEN) {
            return ['single', view('articles.assembly.AjaxArticle', [
                'id' => $article['id']
            ])];
        }
        if ($article['iframe'] == LocalArticle::OPEN) {
            $url = URL::B($article['user_id']);
            $url = $url . '/iframe/' . $article['id'];
            return ['single', view('articles.assembly.frame', [
                'url' => $url,
                'content' => $article['content']
            ])];
        }
    }
}