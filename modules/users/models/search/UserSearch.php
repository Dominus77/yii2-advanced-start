<?php
namespace modules\users\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\users\models\User;

/**
 * Class UserSearch
 * @package modules\users\models\backend
 *
 * @property string $userRoleName User Role Name
 * @property string $date_from Date From
 * @property string $date_to Date To
 * @property integer $pageSize Page Size
 */
class UserSearch extends User
{
    public $userRoleName;
    public $date_from;
    public $date_to;
    public $pageSize;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->pageSize = Yii::$app->params['user.pageSize'];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'status', 'pageSize'], 'integer'],
            [['username', 'email', 'role', 'userRoleName', 'date_from', 'date_to'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here
        $query->leftJoin('{{%auth_assignment}}', '{{%auth_assignment}}.user_id = {{%user}}.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'username',
                'email',
                'status',
                'userRoleName' => [
                    'asc' => ['item_name' => SORT_ASC],
                    'desc' => ['item_name' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Role Name',
                ],
                'last_visit'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'item_name', $this->userRoleName])
            ->andFilterWhere(['>=', 'last_visit', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'last_visit', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        if ($this->pageSize) {
            $dataProvider->pagination->pageSize = $this->pageSize;
        }

        $dataProvider->pagination->totalCount = $query->count();
        return $dataProvider;
    }
}
