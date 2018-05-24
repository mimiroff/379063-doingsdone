<?php $hidden_attr = isset($errors) ? '' : 'hidden';?>

<div class="modal" <?=$hidden_attr;?> id="project_add">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Добавление проекта</h2>

    <form class="form"  action="add-project.php" method="post">
        <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            <?php $class_name = isset($errors['name']) ? 'form__input--error' : '';
            $error_message = isset($errors['name']) ? $errors['name'] : '';?>
            <input class="form__input <?=$class_name;?>" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
            <p class="form__message"><?=$error_message;?></p>
        </div>

        <div class="form__row form__row--controls">
            <?php if (isset($errors)):?>
                <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
            <?php endif;?>
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</div>