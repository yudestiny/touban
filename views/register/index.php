<h2>社員の登録</h2>
<?php if (!empty($_POST['name'])) : ?>
  <? header('Location:/../'); ?>
<?php endif; ?>
<?php if (empty($_POST['btn_submit']) && !empty($_SESSION['success_message'])) : ?>
  <p class="success_message"><?php echo htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?></p>
  <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<?php if (!empty($errors)) : ?>
  <?php foreach ($errors as $error) : ?>
    <p><?= $error; ?></p>
  <?php endforeach; ?>
<?php endif; ?>
<!-- <?php var_dump($errors) ?> -->
<div>
  <form action="" method="POST" >
    <label for="name">名前</label>
    <input type="text" id="name" name="name">
    <label for="max">タイプ</label>
    <select name="type" >
      <?php foreach($types as $type) : ?>
    <option value="<?= ($type['id']) ?>"><?= ($type['name']) ?></option>
      <?php endforeach ?>
    </select>
    <label for="max">当番最大回数</label>
    <input type="number" id="max" name="max"/>
    <label for="min">当番最小回数</label>
    <input type="number" id="min" name="min"/>
    <input type="submit" value="登録する" />
  </form>
  <iframe src="" name="iframe" frameborder="0"></iframe>
  <div>
    <p>社員一覧（編集）</p>
    <?php foreach ($members as $member) : ?>
      <p>
        <a href="editor?id=<?= $member['id'] ?>"><?= $member['name'];  ?></a>
        　　当番最大回数:<?= $member['maxLimit']; ?>　　当番最小回数:<?= $member['minLimit']; ?>
      </p>
    <?php endforeach; ?>
  </div>

</div>
<?php
