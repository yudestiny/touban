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
<div class="container bg-light p-3 m-4 rounded">
  <p class="fw-bold">入力フォーム</p>
  <form action="" method="POST" >
    <div class="d-flex justify-content-around p-2">
      <div>
        <label for="name">名前</label>
        <input type="text" id="name" name="name">
      </div>
      <div>
        <label for="max">タイプ</label>
        <select name="type" >
          <?php foreach($types as $id => $name) : ?>
            <option value="<?= $id ?>"><?= $name ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="d-flex justify-content-around p-4">
      <div>
        <label for="max">当番最大回数</label>
        <input type="number" id="max" name="max"/>
      </div>
      <div>
        <label for="min">当番最小回数</label>
        <input type="number" id="min" name="min"/>
      </div>
    </div>
    <div class="d-flex justify-content-end p-2">
      <input type="submit" value="登録する" class="btn btn-warning">

    </div>
  </form>
</div>
  <div class="container bg-light p-3 m-4 rounded">
    <p class="fw-bold">社員一覧（編集）</p>
    <?php foreach ($members as $member) : ?>
      <ul class="list-group list-group-horizontal justify-content-center me-auto">
        <a href="editor?id=<?= $member['id'] ?>">
          <li class="list-group-item fw-bold">
            <?= $member['name'];  ?>
          </li>
        </a>
        <li class="list-group-item">
          タイプ：<?= $types[$member['type_id']] ?>
        </li>
        <li class="list-group-item">
          当番回数: 最大<?= $member['maxLimit']; ?>, 最小:<?= $member['minLimit']; ?>
        </li>
      </ul>
    <?php endforeach; ?>
  </div>

<?php
