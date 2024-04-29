<div class="container mt-5">
  <h3 class="mb-4"><span class="mx-3"><?php echo $html_title ?></span></h3>
<form action="shuffle/index?ym=<?= $ym ?>" method="POST">
  <table class="table table-bordered">
  <tr>
          <?php foreach (["日", "月", "火", "水", "木", "金", "土"] as $day) : ?>
          <th class="mw-25 text-center"><?= $day ?></th>
          <?php endforeach ?>
        </tr>
      <?php foreach ($weeks as $week) : ?>
        <?= $week; ?>
      <?php endforeach; ?>
  </table>
    <div class="align-items-center px-2 d-flex justify-content-between">
        <a href="/touban/" class="link-dark link-offset-2 link-underline link-underline-opacity-0">戻る</a>
        <input type="submit" value="当番を割り振る" class="btn btn-warning">
      </div>
      </form>
    <div>
  </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
  // チェックボックスを含む td 要素をクリックしたときに、チェックボックスをクリック
  $('td:has(input[type=checkbox])').on('click', function(e) {
    $(this).find('input[type=checkbox]').click();
  });
  // バブリングを防止
  $('td input[type=checkbox]').on('click', function(e) {
    e.stopPropagation();
  });
</script>
