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

      $week .= "<input type=\"checkbox\" class=\"btn-check\" value=\"{$day}\" name=\"select[]\">
      <label class=\"btn btn-primary w-100\">$day</label></td>";

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
    $touban = [];
    $toubanbi = "";
    $previousToubanDay = '';
    $members = $this->databaseManager->get('Member')->fetchAllName('asc');

    // 各メンバーに定めた当番回数をもとにタイプごとに最低と最大をそれぞれ配列にまとめる
    if (!empty($members)) {
      foreach ($members as $member) {
        if ($member['type_id'] === 1 || $member['type_id'] === 3) {
          for ($i = 0; $i < $member['minLimit']; $i++) {
            $minSupervisorList[] = [
              'id' => $member['id'],
              'name' => $member['name'],
              'type' => $member['type_id']
            ];
          }
          for ($i = 0; $i < $member['maxLimit'] - $member['minLimit']; $i++) {
            $maxSupervisorList[] = [
              'id' => $member['id'],
              'name' => $member['name'],
              'type' => $member['type_id']
            ];
          }
        }
        if ($member['type_id'] === 2 || $member['type_id'] === 3) {
          for ($i = 0; $i < $member['minLimit']; $i++) {
            $minMemberList[] = [
              'id' => $member['id'],
              'name' => $member['name'],
              'type' => $member['type_id']
            ];
          }
          for ($i = 0; $i < $member['maxLimit'] - $member['minLimit']; $i++) {
            $maxMemberList[] = [
              'id' => $member['id'],
              'name' => $member['name'],
              'type' => $member['type_id']
            ];
          }
        }
      }
    }
    // タイプごとにリスト化し、要素の少ない方をメンバー数の確認に適用する
    $supervisorList = array_merge($minSupervisorList, $maxSupervisorList);
    $memberList = array_merge($minMemberList, $maxMemberList);
    $judging = $supervisorList;
    if (count($supervisorList) > count($memberList)) {
      $judging = $memberList;
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
      // 選択した当番日数に対して割り当てられるメンバーが不足している場合エラーにて処理
      if ($toubanbi && count($toubanbi) >count($judging)) {
        $errors['memberOver'] = '選択した当番日数を満たすメンバーの数が足りません';
      }
    
      // shuffle()は要素が２つ以上ないとエラーになるためif文で確認した後処理、冗長化するため関数化
      function shuffleTouban ($supervisorList, $memberList) {
        
        // 当番を残り少なくとも一回割り当てられるメンバーの数を重複なしにそれぞれ表現
        $NoDuplicatedList = [];
        $NoDuplicatedList = [
          'supervisor' => array_count_values(array_column($supervisorList,'id')),
          'member' => array_count_values(array_column($memberList,'id'))
        ];
        if (count($NoDuplicatedList['supervisor']) > 1) {
          shuffle($supervisorList);
        }
        if (count($NoDuplicatedList['member']) > 1) {
          shuffle($memberList);
        }

        return [$supervisorList, $memberList];
      };

      if (empty($errors)) {
        for ($day = 1; $day <= $day_count; $day++, $youbi++) {
          if (!empty($errors)) {
            break;
          }
          // 2021-06-3
          $date = $ym . '-' . $day;

        if ($today == $date) {
          // 今日の日付の場合は、class="today"をつける
          $week .= '<td class="today">' . $day;
        } else {
          $week .= '<td>' . ' ' . $day;
        }

        // 最低当番回数の登録されたメンバーがすべて割り振られた場合、最大当番回数の登録分を割り振るための処理
        if (!count($minSupervisorList)) {
          $minSupervisorList = [...$minSupervisorList, ...$maxSupervisorList];
          $maxSupervisorList = [];
        } 
        if (!count($minMemberList)) {
          $minMemberList = [...$minMemberList, ...$maxMemberList];
          $maxMemberList = [];
        }

        if (!empty($toubanbi) && in_array($day, $toubanbi)) {
          list($minSupervisorList, $minMemberList) = shuffleTouban($minSupervisorList, $minMemberList);

          if ($previousToubanDay) {
            while (true) {
              $inARow = (in_array($minSupervisorList[0]['id'], array_column($touban[$previousToubanDay],'id')) || in_array($minMemberList[0]['id'], array_column($touban[$previousToubanDay],'id')));
              if ($minSupervisorList[0]['id'] === $minMemberList[0]['id'] || $inARow) {
                list($minSupervisorList, $minMemberList) = shuffleTouban($minSupervisorList, $minMemberList);
                if (count(array_count_values(array_column($minSupervisorList,'id'))) <= 1) {
                  $minSupervisorList = [...$minSupervisorList, ...$maxSupervisorList];
                  $maxSupervisorList = [];
                  if (count(array_count_values(array_column($minSupervisorList,'id'))) <= 1) {
                    $errors[] = "当番を割り当てるための十分な当直責任者の数が足りませんでした";
                    break;
                  }
                }
                if (count(array_count_values(array_column($minMemberList,'id'))) <= 1) {
                  $minMemberList = [...$minMemberList, ...$maxMemberList];
                  $maxMemberList = [];
                  if (count(array_count_values(array_column($minMemberList,'id'))) <= 1) {
                    $errors[] = "当番を割り当てるための十分な当直メンバーの数が足りませんでした";
                    break;
                  }
                }
              } else {
                break;
              }
            }
          } else {
            while (true) {
              if ($minSupervisorList[0]['id'] === $minMemberList[0]['id']) {
                list($minSupervisorList, $minMemberList) = shuffleTouban($minSupervisorList, $minMemberList);  
              } else {
                break;
              }
            }
          }
          $touban[$day] = [$minSupervisorList[0],$minMemberList[0]];

          // 当番に選ばれた人のタイプが中堅(mid)のときもう片方のリストからも一つ消す
          // リスト化した時に両方のリストに加えているため
          if ($minSupervisorList[0]['type'] === 3) {
            foreach($minMemberList as $index => $member) {
              if ($minSupervisorList[0]['id'] === $member['id']) {
                unset($minMemberList[$index]);
                break;
              }
            }
          }
          if ($minMemberList[0]['type'] === 3) {
            foreach($minSupervisorList as $index => $supervisor) {
              if ($minMemberList[0]['id'] === $supervisor['id']) {
                unset($minSupervisorList[$index]);
                break;
              }
            }
          }

          array_splice($minSupervisorList, 0, 1);
          array_splice($minMemberList, 0, 1);
          $week .= ' ' . $touban[$day][0]['name'] . ' ' . $touban[$day][1]['name'];
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
    }
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
        'touban' => $touban,
        'toubanbi' => $toubanbi,
        'errors' => $errors,
      ]
    );
  }
}
