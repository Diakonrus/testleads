<?php

class UsersTest extends CDbTestCase
{
    /**
     * @var
     */
    protected $users;

    protected function setUp()
    {
        parent::setUp();
        $this->users = new Users();
    }

    public function testEmailIsRequired()
    {
        $this->users->email = null;
        $this->assertFalse($this->users->validate(['email']));
    }

    public function testPasswordIsRequired()
    {
        $this->users->password = null;
        $this->assertFalse($this->users->validate(['password']));
    }

    public function testAllAttributesHaveLabels()
    {
        $attributes = array_keys($this->users->attributes);

        foreach ($attributes as $attribute) {
            $this->assertArrayHasKey($attribute, $this->users->attributeLabels());
        }
    }

    public function testNameMaxLengthIs250()
    {
        $this->users->description = self::generateString(251);
        $this->assertFalse($this->users->validate(['name']));

        $this->users->description = self::generateString(251);
        $this->assertTrue($this->users->validate(['name']));
    }

    public function testSafeAttributesOnSearchScenario()
    {
        $users = new Users('search');
        $mustBeSafe = ['email', 'code', 'name'];
        $safeAttrs = $users->safeAttributeNames;
        sort($mustBeSafe);
        sort($safeAttrs);
        $this->assertEquals($mustBeSafe, $safeAttrs);
    }

    private static function generateString($length)
    {
        $random = "";
        srand((double)microtime() * 1000000);
        $char_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $char_list .= "abcdefghijklmnopqrstuvwxyz";
        $char_list .= "1234567890";
        // Add the special characters to $char_list if needed
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($char_list, (rand() % (strlen($char_list))), 1);
        }
        return $random;
    }
}