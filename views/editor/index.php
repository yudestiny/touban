<h2>社員の編集</h2>
<div>
  <p><?= $current['name'] ?>さん、こんにちは </p>
  <p>現在の当番最大回数は<?= $current['maxLimit']; ?>回、当番最小回数は<?= $current['minLimit']; ?>回です</p>
</div>
<?php if (empty($_POST['btn_submit']) && !empty($_SESSION['success_message'])) : ?>
  <p class="success_message"><?php echo htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>
<?php unset($_SESSION['success_message']); ?>
<?php if (!empty($errors)) : ?>
  <?php foreach ($errors as $error) : ?>
    <?= $error; ?>
  <?php endforeach; ?>
<?php endif; ?>

<div class="container bg-light p-3 m-4 rounded">
  <p class="fw-bold">入力フォーム</p>
  <form action="./editor?id=<?= $current['id'] ?>" method="POST" >
    <div class="d-flex justify-content-around p-2">
      <div>
        <label for="name">名前</label>
        <input type="text" id="name" name="name" value="<?= $current['name'] ?>">
      </div>
      <div>
        <label for="max">タイプ</label>
        <select name="type" >
      <?php foreach($types as $type) : ?>
    <option value="<?= ($type['id']) ?>"
      <?php if($type['id'] === $current['type']) : ?>
        selected
      <?php endif ?>
    >
    <?= ($type['name']) ?></option>
      <?php endforeach ?>
    </select>
      </div>
    </div>
    <div class="d-flex justify-content-around p-4">
      <div>
        <label for="max">当番最大回数</label>
        <input type="text" id="maxLimit" name="maxLimit" value="<?= $current['maxLimit'] ?>">
      </div>
      <div>
        <label for="min">当番最小回数</label>
        <input type="text" id="minLimit" name="minLimit" value="<?= $current['minLimit'] ?>">
      </div>
    </div>
    <div class="d-flex justify-content-end p-2">
      <input type="submit" value="変更する" class="btn btn-warning">
    </div>
  </form>
</div>
<div><a href="register" class="link-dark link-offset-2 link-underline link-underline-opacity-0">登録/編集ページに戻る</a></div>
