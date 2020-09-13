<?php
namespace App\Service;

use OpenTok\ArchiveMode;
use OpenTok\MediaMode;
use OpenTok\OpenTok;
use OpenTok\Role;

class OpenTokService
{
    protected $opentok;

    protected $key;

    public function __construct()
    {
        $this->key = env('OPENTOK_KEY');
        $this->opentok = new OpenTok($this->key, env('OPENTOK_SECRET'));
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function createSession()
    {
        return $this->opentok->createSession([
            // 'archiveMode' => ArchiveMode::ALWAYS, // 常に録画
            'mediaMode'   => MediaMode::ROUTED // Routedモード
        ]);
    }

    public function getToken($sessionId)
    {
        return $this->opentok->generateToken($sessionId, [
        'role' => Role::MODERATOR, // ロールをモデレータに設定
        'expireTime' => time()+(60 * 60), // 有効期限を1時間に設定
    ]);
    }

    public function getKey()
    {
        return $this->key;
    }
}
