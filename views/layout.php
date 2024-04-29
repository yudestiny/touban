<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>当番割り当て</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <header class="fw-bold fs-2 mb-4 mx-4 mt-1 ps-4 bg-body-secondary rounded d-flex align-items-center ">
  <a href="/touban" class="me-auto link-warning link-offset-2 link-underline link-underline-opacity-0">touban</a>
  <div class="d-flex">
    <a href="/touban/shuffle?ym=<?= $ym ?>" class="border p-2 fs-5 rounded link-warning link-offset-2 link-underline link-underline-opacity-0">シャッフル</a>
    <a href="/touban/create?ym=<?= $ym ?>" class="border p-2 fs-5 rounded link-warning link-offset-2 link-underline link-underline-opacity-0">メンバーの割り当て・編集</a>
    <a href="/touban/register" class="border p-2 fs-5 rounded link-warning link-offset-2 link-underline link-underline-opacity-0">メンバー登録</a>
  </div>
</header>
<div class="p-4 m-4 bg-body-secondary rounded">
  <?= $content; ?>
</div>
</body>

</html>
