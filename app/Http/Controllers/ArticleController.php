<?php


namespace App\Http\Controllers;


use App\Models\LocalArticle;
use App\Models\URL;

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

        if ($article['source_check'] == LocalArticle::OPEN && $article['is_jump'] >= LocalArticle::OPEN) {
            //来源检测 确定是否是A链接跳转过来的
            $ref = $_SERVER['HTTP_REFERER'] ?? null;
            $url = parse_url($ref)['host'] ?? null;
            $isExists = URL::query()
                ->where('url', $url)
                ->where('type', URL::A)
                ->exists();
            if ($isExists === false) {
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
        if ($article['is_encryption'] == LocalArticle::OPEN && $article['is_vue'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {
            return ['template', view('articles.template.ifram_encryp_vue.index')];
        }
        if ($article['is_encryption'] == LocalArticle::OPEN && $article['is_ajax'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {
            return ['template', view('articles.template.ifram_encryp_ajax.index')];
        }
        if ($article['is_encryption'] == LocalArticle::OPEN && $article['is_ajax'] == LocalArticle::OPEN) {
            return ['template', view('articles.template.encryp_ajax.index')];
        }
        if ($article['is_encryption'] == LocalArticle::OPEN && $article['is_vue'] == LocalArticle::OPEN) {
            return ['template', view('articles.template.encryp_vue.index')];
        }
        if ($article['is_encryption'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {
            return ['template', view('articles.template.encryp_iframe.index')];
        }
        if ($article['is_vue'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {
            return ['template', view('articles.template.vue_iframe.index')];
        }
        if ($article['is_ajax'] == LocalArticle::OPEN && $article['iframe'] == LocalArticle::OPEN) {
            return ['template', view('articles.template.ajax_iframe.index')];
        }

        if ($article['is_encryption'] == LocalArticle::OPEN) {
            return ['single', view('articles.assembly.encryptionArticle', [
                'content' =>base64_encode($article['content'])
            ])];
        }
        if ($article['is_vue'] == LocalArticle::OPEN) {
            return ['single', view('articles.assembly.vue')];
        }
        if ($article['is_ajax'] == LocalArticle::OPEN) {
            return ['single', view('articles.assembly.AjaxArticle', [
                'id'=>$article['id']
            ])];
        }
        if ($article['iframe'] == LocalArticle::OPEN) {
            $url = URL::query()
                ->where('type', URL::B)
                ->inRandomOrder()
                ->first()->url;
            $url = $url . '/iframe/'.$article['id'];
            return ['single', view('articles.assembly.frame', [
                'url'=>$url,
                'content'=>$article['content']
            ])];
        }
    }
}