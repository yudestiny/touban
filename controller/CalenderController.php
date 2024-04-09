<?php

class CalenderController extends Controller
{
  public function index()
  {

    // ini_set("memory_limit", "3072M");
    // ini_set("memory_limit", "-1");
    $errors = [];

    date_default_timezone_set('Asia/Tokyo');
    $list = [];

    // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
    if (isset($_GET['ym'])) {
      $ym = $_GET['ym'];
    } else {
      // 今月の年月を表示
      $ym = date('Y-m');
    }

    $timestamp = strtotime($ym . '-01');
    if ($timestamp === false) {
      $ym = date('Y-m');
      $timestamp = strtotime($ym . '-01');
    }

    $today = date('Y-m-j');
    $html_title = date('Y年n月', $timestamp);
    $day_count = date('t', $timestamp);
    $youbi = date('w', $timestamp);


      $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) - 1, 1, date('Y', $timestamp)));
      $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) + 1, 1, date('Y', $timestamp)));

    // カレンダー作成の準備
    $weeks = [];
    $week = '';

    // 第１週目：空のセルを追加
    // 例）１日が火曜日だった場合、日・月曜日の２つ分の空セルを追加する
    $week .= str_repeat('<td></td>', $youbi);
    session_start();
    session_regenerate_id();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['month'])) {

      $month = $_SESSION['month'];
      $schedule = $_SESSION['data'];
      // $this->databaseManager->get('Schedule')->registerSchedule($month);
      $this->databaseManager->get('Schedule')->beginTransaction();
      try {
        foreach ($schedule as $date => $members) {
          $this->databaseManager->get('Schedule')->insert($date, $month, array_column($members, 'id'));
        }

        $this->databaseManager->makeDbhNull();
        $errors[] = $this->databaseManager->get('Schedule')->commit();
      } catch (Exception $e) {
        print('Error:' . $e->getMessage());
        $this->databaseManager->get('Schedule')->rollBack();
        $errors[] = '当番の登録に失敗しました';
      }
      unset($_SESSION['month']);
      unset($_SESSION['data']);
      $_SESSION = [];

    }
    // 当該月の当番データとメンバーデータの取得
    $scheduleData = $this->databaseManager->get('Schedule')->fetchAllMember($ym);
    $members = $this->databaseManager->get('member')->fetchAllName();
    $members = array_column($members, 'name', 'id');
    $this->databaseManager->makeDbhNull();

    for ($day = 1; $day <= $day_count; $day++, $youbi++) {
      // 例：2021-06-3
      $date = $ym . '-' . $day;
      if ($today == $date) {
        // 今日の日付の場合は、class="today"をつける
        $week .= '<td class="today">' . $day;
      } else {
        $week .= '<td>' . ' ' . $day;
      }

      if (!empty($scheduleData) && in_array($day, array_column($scheduleData, 'day'))) {
          foreach ($scheduleData as $data) {
              if ($day == $data['day']) {
                  $week .= '   ' . $members[$data['member_id']];
              }
          }
      }

      $week .= '</td>';

      // 週終わり、または、月終わりの場合
      if ($youbi % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
          // 月の最終日の場合、空セルを追加
          // 例）最終日が水曜日の場合、木・金・土曜日の空セルを追加
          $week .= str_repeat('<td></td>', 6 - $youbi % 7);
        }

        // weeks配列にtrと$weekを追加する
        $weeks[] = '<tr>' . $week . '</tr>';

        // weekをリセット
        $week = '';
      }
    }
    $_GET = [];

    return $this->render(
      ['ym' => $ym,
        'prev' => $prev,
        'next' => $next,
        'today' => $today,
        'html_title' => $html_title,
        'day_count' => $day_count,
        'youbi' => $youbi,
        'weeks' => $weeks,
        'week' => $week,
        'action' => 'index',
        'errors' => $errors,
      ]);
  }

  public function create () {
    $errors = [];

    date_default_timezone_set('Asia/Tokyo');
    $members = $this->databaseManager->get('Member')->fetchAllName('asc');

    // 前月・次月リンクが押された場合は、GETパラメーターから年月を取得
    if (isset($_GET['ym'])) {
      $ym = $_GET['ym'];
    } else {
      // 今月の年月を表示
      $ym = date('Y-m');
    }

    $timestamp = strtotime($ym . '-01');
    if ($timestamp === false) {
      $ym = date('Y-m');
      $timestamp = strtotime($ym . '-01');
    }

    $today = date('Y-m-j');
    $html_title = date('Y年n月', $timestamp);
    $day_count = date('t', $timestamp);
    $youbi = date('w', $timestamp);


      $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) - 1, 1, date('Y', $timestamp)));
      $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) + 1, 1, date('Y', $timestamp)));

    // カレンダー作成の準備
    $weeks = [];
    $week = '';

    // 第１週目：空のセルを追加
    // 例）１日が火曜日だった場合、日・月曜日の２つ分の空セルを追加する
    $week .= str_repeat('<td></td>', $youbi);
    session_start();
    session_regenerate_id();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $touban = $_POST['touban'];
      $day = $_POST['day'];
      var_dump($touban);
      var_dump($day);
      $assignedMembers = [];
      for ($i = 0; $i < count($day); $i+=2) {
        $assignedMembers[$day[$i]] = [$touban[$i], $touban[$i+1]];
      }
      $ym = $_POST['ym'];
      $year = mb_substr($ym, 0, 4);
      $month = mb_substr($ym, -2);
      $this->databaseManager->get('Schedule')->beginTransaction();
      try {
        $this->databaseManager->get('Schedule')->insert($year, $month, $assignedMembers);
        $this->databaseManager->makeDbhNull();
        $errors[] = $this->databaseManager->get('Schedule')->commit();
      } catch (Exception $e) {
        print('Error:' . $e->getMessage());
        $this->databaseManager->get('Schedule')->rollBack();
        $errors[] = '当番の登録に失敗しました';
      }
      unset($_SESSION['month']);
      unset($_SESSION['data']);
      $_SESSION = [];

    }

    // $scheduleOfThisMonth = 'schedule_of_' . str_replace('-', '', $ym);
    // $dataExistence = $this->databaseManager->get('Schedule')->checkTableExistence($scheduleOfThisMonth);

    // if ($dataExistence) {
      $scheduleData = $this->databaseManager->get('Schedule')->fetchAllMember(str_replace('-', '', $ym));
    // }

    $this->databaseManager->makeDbhNull();

    for ($day = 1; $day <= $day_count; $day++, $youbi++) {

      // 2021-06-3
      $date = $ym . '-' . $day;

      if ($today == $date) {
        // 今日の日付の場合は、class="today"をつける
        $week .= '<td class="today">' . $day;
      } else {
        $week .= '<td>' . ' ' . $day;
      }

      if (!empty($scheduleData)) {
          foreach ($scheduleData as $data) {
              if ($day == $data['date']) {
                  $week .= '   ' . $data['member'];
              }
          }
      }
      $option = '';
      foreach ($members as $member) {
        $option .= "<option value=\"{$member['id']}\" >{$member['name']}</option>";
      }

      $week .= "{$day}<select value=\"{$day}\" name=\"member\">{$option}</select></td>";

      // 週終わり、または、月終わりの場合
      if ($youbi % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
          // 月の最終日の場合、空セルを追加
          // 例）最終日が水曜日の場合、木・金・土曜日の空セルを追加
          $week .= str_repeat('<td></td>', 6 - $youbi % 7);
        }

        // weeks配列にtrと$weekを追加する
        $weeks[] = '<tr>' . $week . '</tr>';

        // weekをリセット
        $week = '';
      }
    }
    $_GET = [];

    return $this->render(
      [
        'members' => $members,
        'ym' => $ym,
        'prev' => $prev,
        'next' => $next,
        'today' => $today,
        'html_title' => $html_title,
        'day_count' => $day_count,
        'youbi' => $youbi,
        'weeks' => $weeks,
        'week' => $week,
        'action' => 'create',
        'errors' => $errors,
      ], 'index');
  }
}
