<?php

class RegisterController extends Controller
{
  public function index()
  {
    $errors = [];
    $types = $this->databaseManager->get('Type')->fetchAllType();
    var_dump($_POST);
    var_dump($_SERVER['REQUEST_METHOD']);
    // var_dump($_POST['max']);
    // var_dump($_POST['min']);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      echo "1111";
      $name = trim(mb_convert_kana($_POST['name'], 's', 'UTF-8'));
      $type = $_POST['type'];
      $max = $_POST['max'];
      $min = $_POST['min'];

      if (!strlen($name)) {
        $errors['name'] = '名前を入力してください';
      } elseif (strlen($name) > 20) {
        $errors['name'] = '名前は20文字以内で入力してください';
      }

      if (!strlen($max)) {
        $errors['max'] = '当番最大回数を入力してください';
      } elseif ($max > 5) {
        $errors['max'] = '当番最大回数は最大5回です';
      } elseif ($min > $max) {
        $errors['max'] = '当番最小回数が当番最大回数を上回っています';
      }
      if(!strlen($min)) {
        $errors['min'] = '当番最小回数を入力してください';
      } elseif ($min > 5) {
        $errors['min'] = '当番最小回数は最大5回です';
      }

        if (empty($errors)) {
          var_dump('2222');
          $this->databaseManager->get('Member')->beginTransaction();

          try{
              $this->databaseManager->get('Member')->insert($name, $type, $max, $min);
              $errors[] = $this->databaseManager->get('Member')->commit();

          } catch (Exception $e) {
              $this->databaseManager->get('Member')->rollBack();
              $errors[] = '社員の登録に失敗しました';
            }
            header('Location:./register');
            exit();
          }
        $_POST = null;
}

    $members = $this->databaseManager->get('Member')->fetchAllName();

    $this->databaseManager->makeDbhNull();
    $_POST = [];


    return $this->render(
      [
        'types' => $types,
        'members' => $members,
        'errors' => $errors,
      ]
      );
  }
}
