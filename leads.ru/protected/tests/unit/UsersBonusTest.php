<?php

class UsersBonusTest extends CDbTestCase
{
    /**
     * @var
     */
    protected $bonus;

    protected function setUp()
    {
        parent::setUp();
        $this->bonus = new UsersBonus();
    }

    public function testUserIsRequired()
    {
        $this->bonus->user_id = null;
        $this->assertFalse($this->bonus->validate(['user_id']));
    }

    public function testBonusIsRequired()
    {
        $this->bonus->bonus = null;
        $this->assertFalse($this->bonus->validate(['bonus']));
    }

    public function testRelations()
    {
        $bonus = UsersBonus::model()->find();

        $this->assertInstanceOf('Users', $bonus->user);
    }

    public function testAllAttributesHaveLabels()
    {
        $attributes = array_keys($this->bonus->attributes);

        foreach ($attributes as $attribute) {
            $this->assertArrayHasKey($attribute, $this->bonus->attributeLabels());
        }
    }

    public function testSafeAttributesOnSearchScenario()
    {
        $bonus = new UsersBonus('search');
        $mustBeSafe = ['updated_at', 'created_at'];
        $safeAttrs = $bonus->safeAttributeNames;
        sort($mustBeSafe);
        sort($safeAttrs);
        $this->assertEquals($mustBeSafe, $safeAttrs);
    }

}