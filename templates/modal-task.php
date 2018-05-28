<?php $hidden_attr = !empty($errors) ? '' : 'hidden';?>

<div class="modal" <?=$hidden_attr;?> id="task_add">
  <button class="modal__close" type="button" name="button" href="/">Закрыть</button>

  <h2 class="modal__heading">Добавление задачи</h2>

  <form class="form"  action="add-task.php" method="post" enctype="multipart/form-data">
    <div class="form__row">
      <label class="form__label" for="name">Название <sup>*</sup></label>
      <?php $class_name = isset($errors['name']) ? 'form__input--error' : '';
      $error_message = isset($errors['name']) ? $errors['name'] : '';?>
      <input class="form__input <?=$class_name;?>" type="text" name="name" id="name" value="" placeholder="Введите название">
      <p class="form__message"><?=$error_message;?></p>
    </div>

    <div class="form__row">
      <label class="form__label" for="project">Проект <sup>*</sup></label>
        <?php $class_name = isset($errors['project']) ? 'form__input--error' : '';
        $error_message = isset($errors['project']) ? $errors['project']: ''?>
      <select class="form__input form__input--select" name="project" id="project">
        <option value="Входящие">Входящие</option>
          <?php foreach ($projects as $project): ?>
          <option value="<?=$project['id'];?>"><?=$project['project_name'];?></option>
          <?php endforeach;?>
      </select>
      <p class="form__message"><?=$error_message;?></p>
    </div>

    <div class="form__row">
      <label class="form__label" for="date">Срок выполнения</label>
      <?php $class_name = isset($errors['date']) ? 'form__input--error' : '';
      $error_message = isset($errors['date']) ? $errors['date']: ''?>
      <input class="form__input form__input--date" type="text" name="date" id="date"
             placeholder="Введите дату и время">
      <p class="form__message"><?=$error_message;?></p>
    </div>

    <div class="form__row">
      <label class="form__label" for="preview">Файл</label>

      <div class="form__input-file">
        <input class="visually-hidden" type="file" name="preview" id="preview" value="">

        <label class="button button--transparent" for="preview">
            <span>Выберите файл</span>
        </label>
      </div>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" name="" value="Добавить">
    </div>
  </form>
    <?php $error_message = !empty($errors) ? 'Пожалуйста, исправьте ошибки в форме' : '';?>
    <p class="form__message"><?=$error_message;?></p>
</div>
