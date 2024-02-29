<?php

class RegisterController extends Controller
{
  public function index()
  {
    $errors = [];

    echo $_SERVER['REQUEST_METHOD'];
    var_dump($_POST);
    if (!empty($_POST['name'])) {
      $name = trim(mb_convert_kana($_POST['name'], 's', 'UTF-8'));
      $limit = trim(mb_convert_kana($_POST['limit'], 's', 'UTF-8'));

      if (!strlen($name)) {
        $errors['name'] = '名前を入力してください';
      } elseif (strlen($name) > 20) {
        $errors['name'] = '名前は20文字以内で入力してください';
      }

      if (!strlen($limit)) {
        $errors['limit'] = '当番最大回数を入力してください';
      } elseif ($limit > 5) {
        $errors['limit'] = '当番最大回数は最大5回です';
      }

        if (empty($errors)) {
          $this->databaseManager->get('Member')->beginTransaction();

          try{
              $this->databaseManager->get('Member')->insert($name, $limit);
              $errors[] = $this->databaseManager->get('Member')->commit();

          } catch (Exception $e) {
              $this->databaseManager->get('Member')->rollBack();
              $errors[] = '社員の登録に失敗しました';
          }
      }
      header('Location:./register');
      exit();
        $_POST = null;
}

    $members = $this->databaseManager->get('Member')->fetchAllName();

    $this->databaseManager->makeDbhNull();
    $_POST = [];
    var_dump($_POST);


    return $this->render(
      [
        'members' => $members,
        'errors' => $errors,
        'members' => $members,
      ]
      );
  }
}
