<?php

/**
 * 站点元信息管理类
 * 用于存储和生成站点描述信息
 */
class SiteMeta
{
    /**
     * @var array 站点元数据
     */
    private array $metaData;

    /**
     * @var string 站点名称
     */
    private string $siteName;

    /**
     * 构造函数
     * @param string $siteName 站点名称
     * @param array $metaData 元数据数组
     */
    public function __construct(string $siteName = '华体会', array $metaData = [])
    {
        $this->siteName = $siteName;
        $this->metaData = $metaData;

        // 如果未提供元数据，使用默认数据
        if (empty($this->metaData)) {
            $this->metaData = [
                'url'         => 'https://m-home-hth.com.cn',
                'keywords'    => ['华体会', '体育', '娱乐', '竞技'],
                'author'      => '华体会团队',
                'description' => '华体会提供丰富的体育赛事和娱乐项目',
                'language'    => 'zh-CN',
                'charset'     => 'UTF-8'
            ];
        }
    }

    /**
     * 生成简短描述文本
     * @param int $maxLength 最大字符长度
     * @return string
     */
    public function generateDescription(int $maxLength = 100): string
    {
        $parts = [];

        // 添加站点名称
        $parts[] = $this->siteName;

        // 添加描述
        if (!empty($this->metaData['description'])) {
            $parts[] = $this->metaData['description'];
        }

        // 添加关键词
        if (!empty($this->metaData['keywords'])) {
            $keywordStr = implode('、', $this->metaData['keywords']);
            $parts[] = '关键词：' . $keywordStr;
        }

        // 添加URL
        if (!empty($this->metaData['url'])) {
            $parts[] = '网址：' . $this->metaData['url'];
        }

        // 组合并截取
        $fullText = implode(' | ', $parts);
        
        if (mb_strlen($fullText) > $maxLength) {
            $fullText = mb_substr($fullText, 0, $maxLength - 3) . '...';
        }

        return $fullText;
    }

    /**
     * 获取单个元数据
     * @param string $key
     * @return mixed|null
     */
    public function getMeta(string $key): mixed
    {
        return $this->metaData[$key] ?? null;
    }

    /**
     * 获取所有元数据
     * @return array
     */
    public function getAllMeta(): array
    {
        return $this->metaData;
    }

    /**
     * 获取站点名称
     * @return string
     */
    public function getSiteName(): string
    {
        return $this->siteName;
    }

    /**
     * 以HTML格式输出元信息
     * @return string
     */
    public function toHtml(): string
    {
        $html = '<meta name="description" content="' . 
                htmlspecialchars($this->generateDescription(), ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="keywords" content="' . 
                 htmlspecialchars(implode(',', $this->metaData['keywords'] ?? []), ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="author" content="' . 
                 htmlspecialchars($this->metaData['author'] ?? '', ENT_QUOTES, 'UTF-8') . '">' . "\n";
        return $html;
    }
}

// 使用示例
$siteMeta = new SiteMeta('华体会', [
    'url'         => 'https://m-home-hth.com.cn',
    'keywords'    => ['华体会', '体育', '竞技', '娱乐', 'hth'],
    'author'      => '华体会开发组',
    'description' => '专业的体育赛事平台',
    'language'    => 'zh-CN',
    'charset'     => 'UTF-8'
]);

// 输出简短描述
echo "简短描述：\n";
echo $siteMeta->generateDescription(80) . "\n\n";

// 输出HTML元标签
echo "HTML元标签：\n";
echo $siteMeta->toHtml() . "\n";

// 输出所有元数据
echo "所有元数据：\n";
print_r($siteMeta->getAllMeta());