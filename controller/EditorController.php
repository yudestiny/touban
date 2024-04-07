<?php

class EditorController extends Controller
{
  public function index()
  {

    $errors = [];
    $current = [];
    $current['id'] = $_GET['id'];

    $types = $this->databaseManager->get('Type')->fetchAllType();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = trim(mb_convert_kana($_POST['name'], "s", 'UTF-8'));
      $type = $_POST['type'];
      $maxLimit = trim(mb_convert_kana($_POST['maxLimit'], "s", 'UTF-8'));
      $minLimit = trim(mb_convert_kana($_POST['minLimit'], "s", 'UTF-8'));

      if (!strlen($name)) {
        $errors['name'] = '名前を入力してください';
      } elseif (strlen($name) > 20) {
        $errors['name'] = '名前は20文字以内で入力してください';
      }

      if (!strlen($maxLimit)) {
        $errors['maxLimit'] = '当番最大回数を入力してください';
      } elseif ($maxLimit > 5) {
        $errors['maxLimit'] = '当番最大回数は最大5回です';
      } elseif ($minLimit > $maxLimit) {
        $errors['maxLimit'] = '当番最小回数が当番最大回数を上回っています';
      }
      if(!strlen($minLimit)) {
        $errors['minLimit'] = '当番最小回数を入力してください';
      } elseif ($minLimit > 5) {
        $errors['minLimit'] = '当番最小回数は最大5回です';
      }

      if (empty($errors)) {
        $this->databaseManager->get('Member')->beginTransaction();

        try {
          $this->databaseManager->get('Member')->update($current['id'], $name, $type, $maxLimit, $minLimit);
          $errors[] = $this->databaseManager->get('Member')->commit();

        } catch (Exception $e) {
          $this->databaseManager->get('Member')->rollBack();
          $errors[] = '社員情報の更新に失敗しました';
        }
        
      header('Location:/touban/register');
      exit();
      }
      // Header('Location:' . $_SERVER['REQUEST_URI']);
    }
    $members = $this->databaseManager->get('Member')->fetchAllName();

    foreach ($members as $member) {
      if ($current['id'] == $member['id']) {
        $current['name'] = $member['name'];
        $current['type'] = $member['type_id'];
        $current['maxLimit'] = $member['maxLimit'];
        $current['minLimit'] = $member['minLimit'];
      }
    }

    return $this->render([
      'title' => '社員の編集',
      'members' => $members,
      'errors' => $errors,
      'current' => $current,
      'types' => $types,
    ]);
  }
}
