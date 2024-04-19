<?php

class RegisterController extends Controller
{
  public function index()
  {
    $errors = [];
    $types = array_column($this->databaseManager->get('Type')->fetchAllType(), 'name', 'id');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
    if (isset($_GET['ym'])) {
      $ym = $_GET['ym'];
    } else {
      // 今月の年月を表示
      $ym = date('Y-m');
    }
    $members = $this->databaseManager->get('Member')->fetchAllName();

    $this->databaseManager->makeDbhNull();
    $_POST = [];


    return $this->render(
      [
        'ym' => $ym,
        'types' => $types,
        'members' => $members,
        'errors' => $errors,
      ]
      );
  }
}
