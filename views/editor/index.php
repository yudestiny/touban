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
<div>
  <form action="./editor?id=<?= $current['id'] ?>" method='POST'>
    <label for="name">名前</label>
    <input type="text" id="name" name="name" value="<?= $current['name'] ?>">
    <select name="type" >
      <?php foreach($types as $type) : ?>
    <option value="<?= ($type['id']) ?>"
      <?php if($type['id'] === $current['type']) : ?>
        selected
      <?php endif ?>
    ><?= ($type['name']) ?></option>
      <?php endforeach ?>
    </select>
    <label for="maxLimit">当番最大回数</label>
    <input type="text" id="maxLimit" name="maxLimit" value="<?= $current['maxLimit'] ?>">
    <label for="minLimit">当番最小回数</label>
    <input type="text" id="minLimit" name="minLimit" value="<?= $current['minLimit'] ?>">
    <input type="submit" value="変更する">
  </form>
</div>
<div><a href="register">登録/編集ページに戻る</a></div>
