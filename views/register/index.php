<h2>社員の登録</h2>
<? if (!empty($_POST['name'])) : ?>
  <? Header('Location:/'); ?>
<? endif; ?>
<?php if (empty($_POST['btn_submit']) && !empty($_SESSION['success_message'])) : ?>
  <p class="success_message"><?php echo htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?></p>
  <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<? if (!empty($errors)) : ?>
  <? foreach ($errors as $error) : ?>
    <? echo $error; ?>
  <? endforeach; ?>
<? endif; ?>
<div>
  <form action="/register" method="POST" value="">
    <label for="name">名前</label>
    <input type="text" id="name" name="name" value="">
    <label for="limit">当番最大回数</label>
    <input type="text" id="limit" name="limit" value="">
    <input type="submit" value="登録する">
  </form>
  <div>
    <p>社員一覧（編集）</p>
    <? foreach ($members as $member) : ?>
      <p><a href="/editor?id=<?= $member['id'] ?>"><? echo $member['name'];  ?></a>　　当番最大回数:<? echo $member['maxLimit']; ?></p>
    <? endforeach; ?>
  </div>

</div>
<?php
