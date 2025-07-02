<?php

namespace App\Features;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Outlook
{
    protected string $uri;

    protected string $tenant_id;

    protected string $client_id;

    protected string $client_secret;

    protected string $scope;

    protected string $access_token;

    protected string $email;

    public function __construct()
    {
        $this->uri = config('services.outlook.uri');
        $this->tenant_id = config('services.outlook.tenant');
        $this->client_id = config('services.outlook.key');
        $this->client_secret = config('services.outlook.secret');
        $this->scope = config('services.outlook.scopes');
        $this->email = config('services.outlook.email');
        $this->access_token = $this->getAccessToken();
    }

    public function getAccessToken(): string
    {
        $cacheKey = 'outlook_access_token';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::asForm()->post("https://login.microsoftonline.com/{$this->tenant_id}/oauth2/v2.0/token", [
            'grant_type' => 'client_credentials',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'scope' => $this->scope,
        ]);

        $accessToken = $response['access_token'];
        $expiresIn = $response['expires_in'] ?? 3600; // typically 3600 seconds (1 hour)

        Cache::put($cacheKey, $accessToken, now()->addSeconds($expiresIn - 300));

        return $accessToken;
    }

    // GET /outlook/folders
    public function getFolders()
    {
        $response = Http::withToken($this->access_token)
            ->get("{$this->uri}/v1.0/users/{$this->email}/mailFolders");

        return $response->json()['value'];
    }

    // GET /outlook/folders/{folderId}/children
    public function getChildFolders(string $folderId)
    {
        $response = Http::withToken($this->access_token)
            ->get("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/childFolders");

        return $response->json()['value'];
    }


    // GET /outlook/folders/{folderId}/messages?pageSize=10
    public function getMessagesFromFolder(string $folderId, array $params = [])
    {
        $response = Http::withToken($this->access_token)
            ->get("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages",$params);

        return $response->json();
    }

    // GET /outlook/folders/{folderId}/messages/{messageId}
    public function getMessage(string $folderId, string $messageId)
    {
        $response = Http::withToken($this->access_token)
            ->get("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}");

        return $response->json();
    }

    // POST /outlook/folders/{folderId}/messages/{messageId}/move
    // BODY: { "destinationId": "folderId" }
    public function move(string $folderId, string $messageId, string $destinationId)
    {
        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/move", [
                'destinationId' => $destinationId
            ]);

        return $response->json();
    }

    // POST /outlook/folders/{folderId}/messages/{messageId}/send
    public function sendFromDraft(string $folderId, string $messageId)
    {
        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/send");

        return $response->json();
    }

    /**
     * PATCH /outlook/folders/{folderId}/messages/{messageId}
     *
     * {
     *  "subject": "subject-value",
     *  "body": {
     *    "contentType": "",
     *    "content": "content-value"
     *  },
     *  "inferenceClassification": "other"
     * }
     */
    public function updateMessage(string $folderId, string $messageId, Request $request)
    {
        $data = $request->all();

        $response = Http::withToken($this->access_token)
            ->patch("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}", $data);

        return $response->json();
    }


    /**
     * POST /outlook/folders/{folderId}/messages/{messageId}/reply
     * {
     *     "message":{
     *       "toRecipients":[
     *         {
     *           "emailAddress": {
     *             "address":"samanthab@contoso.com",
     *             "name":"Samantha Booth"
     *           }
     *         },
     *         {
     *           "emailAddress":{
     *             "address":"randiw@contoso.com",
     *             "name":"Randi Welch"
     *           }
     *         }
     *        ]
     *     },
     *     "comment": "Samantha, Randi, would you name the group please?"
     * }
     */
    public function reply(string $folderId, string $messageId, array $params = [])
    {
        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/reply", $params);

        return $response->json();
    }

    /**
     * POST /outlook/folders/{folderId}/messages/{messageId}/replyAll
     * {
     *   "comment": "comment-value"
     * }
     */
    public function replyAll(string $folderId, string $messageId, array $params = [])
    {
        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/replyAll", $params);

        return $response->json();
    }

    // POST /outlook/folders/{folderId}/messages/{messageId}/createReply
    public function createReplyAsDraft(string $folderId, string $messageId)
    {
        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/createReply");

        return $response->json();
    }

    // POST /outlook/folders/{folderId}/messages/{messageId}/createForward
    public function createReplyAllAsDraft(string $folderId, string $messageId)
    {
        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/createReplyAll");

        return $response->json();
    }

    // POST /outlook/folders/{folderId}/messages/{messageId}/createForward
    public function createDraftForward(string $folderId, string $messageId)
    {
        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/createForward");

        return $response->json();
    }

    /**
     * POST /outlook/folders/{folderId}/messages
     * {
     *    "subject":"Did you see last night's game?",
     *    "importance":"Low",
     *    "body":{
     *        "contentType":"HTML",
     *        "content":"They were <b>awesome</b>!"
     *    },
     *    "toRecipients":[
     *        {
     *            "emailAddress":{
     *                "address":"ian.sebastian@dsv.com"
     *            }
     *        }
     *    ]
     * }
     */
    public function createDraftMessage(string $folderId, array $data)
    {
        // $data = $request->all();
        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages", $data);

        return $response->json();
    }

    /**
     * POST /outlook/send-mail
     *
     * {
     *  "message": {
     *    "subject": "Meet for lunch?",
     *    "body": {
     *      "contentType": "Text",
     *      "content": "The new cafeteria is open."
     *    },
     *    "toRecipients": [
     *      {
     *        "emailAddress": {
     *          "address": "frannis@contoso.com"
     *        }
     *      }
     *    ],
     *    "ccRecipients": [
     *      {
     *        "emailAddress": {
     *          "address": "danas@contoso.com"
     *        }
     *      }
     *    ]
     *  },
     *  "saveToSentItems": "false"
     *}
     */
    public function sendMail(array $data)
    {
        $mailData = [
            'message' => [
                'subject' => $data['subject'],
                'body' => [
                    'contentType' => 'Text',
                    'content' => $data['content'],
                ]
            ],
        ];

        if (isset($data['to_recipients'])) {
            $mailData['message']['toRecipients'] = array_map(function ($recipient) {
                return [
                    'emailAddress' => [
                        'address' => $recipient
                    ]
                ];
            }, $data['to_recipients']);
        }

        if (isset($data['cc_recipients'])) {
            $mailData['message']['ccRecipients'] = array_map(function ($recipient) {
                return [
                    'emailAddress' => [
                        'address' => $recipient
                    ]
                ];
            }, $data['cc_recipients']);
        }

        if (isset($data['bcc_recipients'])) {
            $mailData['message']['bccRecipients'] = array_map(function ($recipient) {
                return [
                    'emailAddress' => [
                        'address' => $recipient
                    ]
                ];
            }, $data['bcc_recipients']);
        }

        // $data = $request->all();
        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/sendMail", $mailData);

        return $response->json();
    }

    // GET /outlook/folders/{folderId}/messages/{messageId}/attachments
    public function getAttachments(string $folderId, string $messageId)
    {
        $response = Http::withToken($this->access_token)
            ->get("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/attachments");

        return $response->json();
    }

    /**
     * POST /outlook/folders/{folderId}/messages/{messageId}/attachments
     *
     *    {
     *      "name": "smile",
     *      "contentBytes": "R0lGODdhEAYEAA7"
     *    }
     */
    public function addAttachmentToMessage(string $folderId, string $messageId, Request $request)
    {
        if (! $request->hasFile('file')) {
            return response()->json([
                'status' => 'failed'
            ]);
        }

        $file = $request->file('file');

        $contentBytes = $file->get();

        $data = [
            'name' => $request->has('name') ? $request->name : Str::uuid(),
            'contentBytes' => $contentBytes
        ];

        $response = Http::withToken($this->access_token)
            ->post(
                "{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/attachments",
                array_merge($data, ['@odata.type' => '#microsoft.graph.fileAttachment'])
            );

        return $response->json();
    }

    // DELETE /outlook/folders/{folderId}/messages/{messageId}/attachments/{attachmentId}
    public function deleteAttachmentToMessage(string $folderId, string $messageId, string $attachmentId)
    {
        $response = Http::withToken($this->access_token)
            ->delete("{$this->uri}/v1.0/users/{$this->email}/mailFolders/{$folderId}/messages/{$messageId}/attachments/{$attachmentId}");

        return $response->json();
    }

    /**
     * POST /outlook/messages/{messageId}/attachments/createUploadSession
     *
     * {
     *  "AttachmentItem": {
     *    "attachmentType": "file",
     *    "name": "flower",
     *    "size": 3483322
     *  }
     * }
     */
    public function createUploadSession(string $messageId, Request $request)
    {
        $data = $request->all();

        $response = Http::withToken($this->access_token)
            ->post("{$this->uri}/v1.0/users/{$this->email}/messages/{$messageId}/attachments/createUploadSession", $data);

        return $response->json();
    }
}
