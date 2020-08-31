<?php
namespace Demoshop;
use Demoshop\service\ProductFactory;
use Demoshop\entity\Product;
use Demoshop\entity\User;
use Demoshop\service\Cart;
use Demoshop\service\Users;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers :: all the operations related to products, user and order
     */
    public function test_getProductCount() {
        $productObj = ProductFactory::getObject("simple");
        $result = $productObj->getProductCount();
        $this->assertInternalType("int", $result);
    }

    public function test_product_list() {
        define('BASEPATH', __DIR__);
        $productObj = ProductFactory::getObject("simple");
        $result = $productObj->getAllProducts();
        $this->assertInstanceOf(Product::class, $result[0], "Please Insert products in database");
    }

    public function test_add_to_cart() {
        $cartObj = new Cart();
        $id = $cartObj->addToCart(2);
        $this->assertInternalType("int", $id);
    }

    public function test_incorrect_product_add_to_cart() {
        $cartObj = new Cart();
        $res = $cartObj->addToCart();
        $this->assertEquals(false, $res);
    }

    public function test_getCartTotal() {
        $cartObj = new Cart();
        $res = $cartObj->getCartTotal();
        $this->assertInternalType("string", $res);
    }

    public function test_email_exists() {
        $userObj = new Users();
        $email = 'rupali.soni'.rand(10,100) .'@gmail.com';
        $result = $userObj->checkUserEmail($email);
        $this->assertEquals(1, $result);
    }

    public function test_add_user() {
        $userObj = new Users();
        $data = array(
            ":firstName"    => "Rupali",
            ":lastName"     => "Soni",
            ":email"      => "rupali.soni19@gmail.com",
            ":password"      => md5("123456")
        );
        $result = $userObj->addUser($data);
        $this->assertInternalType("int", $result);
    }

    public function test_already_exists_email() {
        $userObj = new Users();
        $email = 'rupali.soni19@gmail.com';
        $result = $userObj->checkUserEmail($email);
        $this->assertEquals('Email already exists!', $result);
    }

    public function test_login() {
        $userObj = new Users();
        $hash = md5('testtest');
        $res = $userObj->authenticateUser('rupali.soni19@gmail.com', $hash);
        $this->assertEquals(false, $res);
    }

    public function test_correct_login() {
        $userObj = new Users();
        $hash = md5('123456');
        $res = $userObj->authenticateUser('rupali.soni19@gmail.com', $hash);
        $this->assertInstanceOf(User::class, $res, "Invalid user");
    }
}
