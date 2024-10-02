<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StoryController extends Controller
{
    protected $stories;

    public function __construct()
    {
        // ユーザーの選択肢1　(Saasサービス会社 or ロボット製造会社)
        $currentUserChoiceBusinessSaas = [
            "id" => "current-user-choice-business-saas",
            "character" => "ユーザー（社長）",
            "text" => "「いま流行りのSaaSサービス事業さ！」",
            "next" => "choice-repeat-current-user-choice-saas",
        ];

        $currentUserChoiceBusinessRobot = [
            "id" => "current-user-choice-business-robot",
            "character" => "ユーザー（社長）",
            "text" => "「新型ロボットを世にリリースするんだ！」",
            "next" => "choice-repeat-current-user-choice-robot",
        ];
        $currentUserChoiceBusiness = [
            $currentUserChoiceBusinessSaas,
            $currentUserChoiceBusinessRobot
        ];

        // ユーザーの選択肢2-1 (SaaSサービス会社の場合　SaaSサービスの種類)
        $currentUserChoiceSaasKindnessECommerce = [
            "id" => "current-user-choice-saas-kindness-e-commerce",
            "character" => "ユーザー（社長）",
            "text" => "「品揃え抜群のEコマースSaaSサービスさ！」",
            "next" => "choice-repeat-current-user-choice-saas-kindness-e-commerce"
        ];
        $currentUserChoiceSaasKindnessHumanResource = [
            "id" => "current-user-choice-saas-kindness-human-resource",
            "character" => "ユーザー（社長）",
            "text" => "「バックオフィス業務の効率爆上がりのHRTechのSaaSサービスさ！」",
            "next" => "choice-repeat-current-user-choice-saas-kindness-human-resource"
        ];
        $currentUserChoiceSaasKindnessTaskManegiment = [
            "id" => "current-user-choice-saas-kindness-task-managemant",
            "character" => "ユーザー（社長）",
            "text" => "「1つのタスクも漏らさないタスクマネジメントのSaaSサービスさ！」",
            "next" => "choice-repeat-current-user-choice-saas-kindness-task-managemant"
        ];
        $currentUserChoiceSaasKindness = [
            $currentUserChoiceSaasKindnessECommerce,
            $currentUserChoiceSaasKindnessHumanResource,
            $currentUserChoiceSaasKindnessTaskManegiment
        ];

        // ユーザーの選択肢2-2 (ロボット製造会社の場合　ロボットの種類)
        $currentUserChoiceRobotKindnessHousekeeper = [
            "id" => "current-user-choice-robot-kindness-housekeeper",
            "character" => "ユーザー（社長）",
            "text" => "「家事要らずの家事をそつなくこなす家政婦ロボットさ！」",
            "next" => "choice-repeat-current-user-choice-robot-kindness-housekeeper"
        ];
        $currentUserChoiceRobotKindnessDrone = [
            "id" => "current-user-choice-robot-kindness-drone",
            "character" => "ユーザー（社長）",
            "text" => "「どんな危険なところも調査できる産業用ドローンロボットさ！」",
            "next" => "choice-repeat-current-user-choice-robot-kindness-drone"
        ];
        $currentUserChoiceRobotKindnessAI = [
            "id" => "current-user-choice-robot-kindness-ai",
            "character" => "ユーザー（社長）",
            "text" => "「どんな難問も瞬時に解ける高性能AIロボットさ！」",
            "next" => "choice-repeat-current-user-choice-robot-kindness-ai"
        ];
        $currentUserChoiceRobotKindness = [
            $currentUserChoiceRobotKindnessHousekeeper,
            $currentUserChoiceRobotKindnessDrone,
            $currentUserChoiceRobotKindnessAI
        ];



        // $stories 配列の中で再利用する部分を動的に変更
        $this->stories = [
            // 冒頭の会話
            [
                "id" => "current-user-start",
                "character" => "ユーザー（社長）",
                "text" => "「オレは起業するぞ！」",
                "next" => "friend-surprise",
            ],
            [
                "id" => "friend-surprise",
                "character" => "友人",
                "text" => "「!?!?」",
                "next" => "friend-question-how-business",
            ],

            //ユーザーの選択肢1　(Saasサービス会社 or ロボット製造会社)　の選択
            [
                "id" => "friend-question-how-business",
                "character" => "友人",
                "text" => "「本当に？いきなりどんなビジネスやるってんだい？」",
                "choices" => $currentUserChoiceBusiness
            ],

            //ユーザーの選択肢1　で選択した内容をセリフとしてリピート
            array_merge($currentUserChoiceBusinessSaas, [
                "id" => $currentUserChoiceBusinessSaas['next'],
                "next" => "friend-question-how-saas"
            ]),
            array_merge($currentUserChoiceBusinessRobot, [
                "id" => $currentUserChoiceBusinessRobot['next'],
                "next" => "friend-question-how-robot"
            ]),

            // ユーザーの選択肢2-1 (SaaSサービス会社の場合　SaaSサービスの種類) の選択
            [
                "id" => "friend-question-how-saas",
                "character" => "友人",
                "text" => "「SaaSと一言で言っても色々あるけど‥、どんなSaaSサービスを始めるつもり？」",
                "choices" => $currentUserChoiceSaasKindness
            ],

            //ユーザーの選択肢2-1　で選択した内容をセリフとしてリピート
            array_merge($currentUserChoiceSaasKindnessECommerce, [
                "id" => $currentUserChoiceSaasKindnessECommerce['next'],
                "next" => "friend-reply-to-e-commerce-saas"
            ]),
            array_merge($currentUserChoiceSaasKindnessHumanResource, [
                "id" => $currentUserChoiceSaasKindnessHumanResource['next'],
                "next" => "friend-reply-to-human-resource-saas"
            ]),
            array_merge($currentUserChoiceSaasKindnessTaskManegiment, [
                "id" => $currentUserChoiceSaasKindnessTaskManegiment['next'],
                "next" => "friend-reply-to-task-management-saas"
            ]),

            // ユーザーの選択肢2-1　で選択した内容に対する友人の回答
            [
                "id" => "friend-reply-to-e-commerce-saas",
                "character" => "友人",
                "text" => "「EコマースSaaSサービスかぁ‥!会社名は決めた？」",
                "next" => "current-user-e-commerce-saas-company-name-decision",
            ],
            [
                "id" => "friend-reply-to-human-resource-saas",
                "character" => "友人",
                "text" => "「HRTechのSaaSサービスかぁ‥!会社名は決めた？」",
                "next" => "current-user-human-resource-saas-company-name-decision",
            ],
            [
                "id" => "friend-reply-to-e-commerce-saas",
                "character" => "友人",
                "text" => "「EコマースSaaSサービスかぁ‥!会社名は決めた？」",
                "next" => "current-user-e-commerce-saas-company-name-decision",
            ],

            // 会社名の決定
            [
                "id" => "current-user-e-commerce-saas-company-name-decision",
                "character" => "ユーザー（社長）",
                "text" => "会社名は‥",
                "next" => "choice-repeat-current-user-e-commerce-saas-company-name-decision",
                "showForm" => true, // フォームを表示するためのフラグを追加
            ],
            [
                "id" => "current-user-human-resource-saas-company-name-decision",
                "character" => "ユーザー（社長）",
                "text" => "会社名は‥",
                "next" => "choice-repeat-current-user-human-resource-saas-company-name-decision",
                "showForm" => true, // フォームを表示するためのフラグを追加
            ],
            [
                "id" => "current-user-task-management-saas-company-name-decision",
                "character" => "ユーザー（社長）",
                "text" => "会社名は‥",
                "next" => "choice-repeat-current-user-task-management-saas-company-name-decision",
                "showForm" => true, // フォームを表示するためのフラグを追加
            ],


            // ロボット製造会社の場合
            [
                "id" => "friend-question-how-robot",
                "character" => "友人",
                "text" => "「ロボットと一言で言っても色々あるけど‥、どんなロボットを作って世に出すつもり？」",
                "choices" => $currentUserChoiceRobotKindness
            ],

            //ユーザーの選択肢2-2　で選択した内容をセリフとしてリピート
            array_merge($currentUserChoiceRobotKindnessHousekeeper, [
                "id" => $currentUserChoiceRobotKindnessHousekeeper['next'],
                "next" => "friend-reply-to-housekeeper-robot"
            ]),
            array_merge($currentUserChoiceRobotKindnessDrone, [
                "id" => $currentUserChoiceRobotKindnessDrone['next'],
                "next" => "friend-reply-to-drone-robot"
            ]),
            array_merge($currentUserChoiceRobotKindnessAI, [
                "id" => $currentUserChoiceRobotKindnessAI['next'],
                "next" => "friend-reply-to-ai-robot"
            ]),

            // ユーザーの選択肢2-2　で選択した内容に対する友人の回答
            [
                "id" => "friend-reply-to-housekeeper-robot",
                "character" => "友人",
                "text" => "「家政婦ロボットかぁ‥!会社名は決めた？」",
                "next" => "current-user-housekeeper-robot-company-name-decision",
            ],
            [
                "id" => "friend-reply-to-drone-robot",
                "character" => "友人",
                "text" => "「ドローンロボットかぁ‥!会社名は決めた？」",
                "next" => "current-user-drone-robot-company-name-decision",
            ],
            [
                "id" => "friend-reply-to-ai-robot",
                "character" => "友人",
                "text" => "「AIロボットかぁ‥!会社名は決めた？」",
                "next" => "current-user-ai-robot-company-name-decision",
            ],
            // 会社名の決定
            [
                "id" => "current-user-housekeeper-robot-company-name-decision",
                "character" => "ユーザー（社長）",
                "text" => "会社名は‥[formに入力した内容]だ！",
                "next" => "choice-repeat-current-user-housekeeper-robot-company-name-decision",
            ],
            [
                "id" => "current-user-drone-robot-company-name-decision",
                "character" => "ユーザー（社長）",
                "text" => "会社名は‥[formに入力した内容]だ！",
                "next" => "choice-repeat-current-user-drone-robot-company-name-decision",
            ],
            [
                "id" => "current-user-ai-robot-company-name-decision",
                "character" => "ユーザー（社長）",
                "text" => "会社名は‥[formに入力した内容]だ！",
                "next" => "choice-repeat-current-user-ai-robot-company-name-decision",
            ]
        ];
    }

    public function index()
    {
        // 現在のストーリーIDをセッションから取得
        $currentStoryId = Session::get('current_story', 'current-user-start');
    
        // 現在のストーリーを取得
        $currentStory = $this->getStoryById($currentStoryId);
    
        // セリフIDでフォームの表示を判定
        $showFormForCompanyName = in_array($currentStoryId, [
            'current-user-e-commerce-saas-company-name-decision',
            'current-user-human-resource-saas-company-name-decision',
            'current-user-task-management-saas-company-name-decision'
        ]);
    
        // 会社名が必要な場合、セッションから会社名を取得してセリフに反映
        if ($showFormForCompanyName && Session::has('company_name')) {
            $companyName = Session::get('company_name');
            $currentStory['text'] = str_replace('[formに入力した内容]', $companyName, $currentStory['text']);
        }
    
        return view('story', [
            'story' => $currentStory,
            'showForm' => $showFormForCompanyName,
            'hasNext' => isset($currentStory['next']),
        ]);
    }
    
    public function progress(Request $request)
    {
        // 選択された次のストーリーIDを取得
        $nextStoryId = $request->input('next_story_id');

        // 次のストーリーがあればセッションに保存して進行
        if ($nextStoryId !== null) {
            Session::put('current_story', $nextStoryId);
        }

        return redirect()->route('story');
    }

    // ストーリーをIDで取得するメソッド
    private function getStoryById($id)
    {
        foreach ($this->stories as $story) {
            if ($story['id'] === $id) {
                return $story;
            }
        }
        return $this->stories[0]; // 該当するストーリーが見つからない場合は最初に戻す
    }

    // ストーリーをリセットするメソッド
    public function reset()
    {
        Session::forget('current_story');
        return redirect()->route('story');
    }

    public function saveCompanyName(Request $request)
    {
        // フォームから会社名を取得
        $companyName = $request->input('company_name');

        // 会社名をセッションに保存
        Session::put('company_name', $companyName);

        // セッション内の現在のストーリーIDを取得
        $currentStoryId = Session::get('current_story');

        // 次のストーリーに進むため、セッションに次のストーリーIDをセット
        // (ここでは次のストーリーIDを事前に決めて進めます)
        $nextStoryId = $this->getNextStoryIdAfterCompanyName($currentStoryId);
        if ($nextStoryId !== null) {
            Session::put('current_story', $nextStoryId);
        }

        return redirect()->route('story');
    }

    // 次のストーリーIDを取得するためのヘルパーメソッド
    private function getNextStoryIdAfterCompanyName($currentStoryId)
    {
        // ストーリーIDごとの次のIDを設定
        $nextStoryMap = [
            'current-user-e-commerce-saas-company-name-decision' => 'choice-repeat-current-user-e-commerce-saas-company-name-decision',
            'current-user-human-resource-saas-company-name-decision' => 'choice-repeat-current-user-human-resource-saas-company-name-decision',
            'current-user-task-management-saas-company-name-decision' => 'choice-repeat-current-user-task-management-saas-company-name-decision',
            // 他のケースも必要に応じて追加
        ];

        return $nextStoryMap[$currentStoryId] ?? null;
    }

}
