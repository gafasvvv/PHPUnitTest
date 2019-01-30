<?php

include 'isolate-validation.php';

class IsolateValidationTest extends \PHPUnit\Framework\Testcase{

    public function testDecimalAgeNotValid(){
        $submitted = array('age' => '6.7', 'price' => '100', 'name' => 'Julia');
        list($errors, $input) = validate_form($submitted);
        //一つだけのエラーを期待する　年齢に関するエラー
        $this->assertContains('Please enter a valid age.', $errors);
        $this->assertCount(1, $errors);
    }

    public function testDollarSignPriceNotValid(){
        $submitted = array('age' => '6', 'price' => '$52', 'name' => 'Julia');
        list($errors, $input) = validate_form($submitted);
        //一つだけのエラーを期待する　値段に関するエラー
        $this->assertContains('Please enter a valid price.', $errors);
        $this->assertCount(1, $errors);
    }

    public function testValidDataOK(){
        $submitted = array('age' => '15', 'price' => '39.95',
                        //名前の前後に取り除くべきホワートスペースがある
                            'name' => ' Julia ');
        list($errors, $input) = validate_form($submitted);
        //エラーを予期していない
        $this->assertCount(0, $errors);
        //入力に３つのものを期待する
        $this->assertCount(3, $input);
        $this->assertSame(15, $input['age']);
        $this->assertSame(39.95, $input['price']);
        $this->assertSame('Julia', $input['name']);
    }
}

?>