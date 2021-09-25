<?php

namespace App\Http\Controllers;

use Google\Cloud\PubSub\MessageBuilder;
use Google\Cloud\PubSub\PubSubClient;
use Illuminate\Http\Request;

class HttpNotificationController extends Controller
{
    public function subscribe(Request $request, $t)
    {
        $this->validate($request, [
            'url' => ['required', 'url']
        ]);
        if ($t) {
            $pubSub = new PubSubClient(["projectId" => 'pangaea-327114', 'keyFilePath' => public_path('pangaea-327114-ff95f825cb10.json')]);
            $topic = $pubSub->topic($t);
            if (!$topic->exists()) {
                $pubSub->createTopic($t);
            }
            $subscription = $topic->subscription($t);
            if (!$subscription->exists()) {
                $subscription->create([
                    'pushConfig' => ['pushEndpoint' => $request->url]
                ]);
            }
            return response()->json([
                "url" => $request->url,
                "topic" => $t
            ]);
        } else {
            return response()->json(['message' => 'Topic cannot be empty!'], 422);
        }

    }

    public function publish(Request $request, $t)
    {
        $this->validate($request, [
            'payload' => ['required']
        ]);
        $pubSub = new PubSubClient(["projectId" => 'pangaea-327114', 'keyFilePath' => public_path('pangaea-327114-ff95f825cb10.json')]);
        $topic = $pubSub->topic($t);
        if (!$topic->exists()) {
            return response()->json(['message' => 'Topic not found!!'], 422);
        }
        $topic->publish((new MessageBuilder)->setData(json_encode($request->payload))->build());
        return response()->json(['message' => 'Publish success!']);
    }

    public function message(Request $request)
    {
        printf('Message: %s' . PHP_EOL, $request->all());
    }
}
