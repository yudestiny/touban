<?php

class ShuffleController extends Controller
{
  public function select()
  {
    date_default_timezone_set('Asia/Tokyo');

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

    for ($day = 1; $day <= $day_count; $day++, $youbi++) {


      // 2021-06-3
      $date = $ym . '-' . $day;

      if ($today == $date) {
        // 今日の日付の場合は、class="today"をつける
        $week .= '<td class="today">';
      } else {
        $week .= '<td>';
      }

      $week .= "{$day}<input type=\"checkbox\" value=\"{$day}\" name=\"select[]\"></td>";

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
        'ym' => $ym,
        'prev' => $prev,
        'next' => $next,
        'today' => $today,
        'html_title' => $html_title,
        'day_count' => $day_count,
        'youbi' => $youbi,
        'weeks' => $weeks,
        'week' => $week,
      ]
    );
  }
  public function index()
  {
    date_default_timezone_set('Asia/Tokyo');
    $errors = [];
    $list = [];
    $touban = [];
    $previousToubanDay = '';
    $members = $this->databaseManager->get('Member')->fetchAllName('asc');

    foreach ($members as $member) {
      for ($i = 0; $i < $member['maxLimit']; $i++) {
        $list[] = $member['name'];
      }
    }


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

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['select'])) {
        $toubanbi = $_POST['select'];
      } elseif (!empty($_GET['select'])) {
        $toubanbi = explode(' ', $_GET['select']);
    }

    for ($day = 1; $day <= $day_count; $day++, $youbi++) {


      // 2021-06-3
      $date = $ym . '-' . $day;

      if ($today == $date) {
        // 今日の日付の場合は、class="today"をつける
        $week .= '<td class="today">' . $day;
      } else {
        $week .= '<td>' . ' ' . $day;
      }

      if (!empty($toubanbi) && in_array($day, $toubanbi) && count(array_count_values($list)) > 1) {
        shuffle($list);
        if ($previousToubanDay) {

          while (true) {
            $inARow = (in_array($list[0], $touban[$previousToubanDay]) || in_array($list[1], $touban[$previousToubanDay]));
            if ($list[0] == $list[1] || $inARow) {
              shuffle($list);
            } else {
              break;
            }
          }
        } else {
          while (true) {
            if ($list[0] == $list[1]) {
              shuffle($list);
            } else {
              break;
            }
          }
        }
        $touban[$day] = array_splice($list, 0, 2);
        $week .= ' ' . $touban[$day][0] . ' ' . $touban[$day][1];
        $previousToubanDay = $day;
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
    // header('Location:/');
    session_start();
    $_SESSION['data'] = $touban;
    $_SESSION['month'] = str_replace('-', '', $ym);
    $_GET = [];
    if (!empty($toubanbi)) {
    $toubanbi = implode(' ', $toubanbi);
    } else {
      $errors[] = '当番日を最低1日以上選択してください';
      $toubanbi = '';
    }

    return $this->render(
      [
        'ym' => $ym,
        'prev' => $prev,
        'next' => $next,
        'today' => $today,
        'html_title' => $html_title,
        'day_count' => $day_count,
        'youbi' => $youbi,
        'weeks' => $weeks,
        'week' => $week,
        'toubanbi' => $toubanbi,
        'errors' => $errors,
      ]
    );
  }
}
