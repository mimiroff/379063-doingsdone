<?php $hidden_attr = isset($errors) ? '' : 'hidden';?>

<div class="modal" <?=$hidden_attr;?> id="user_login">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Вход на сайт</h2>

    <form class="form" action="login.php" method="post">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>
            <?php $class_name = isset($errors['email']) ? 'form__input--error' : '';
            $error_message = isset($errors['email']) ? $errors['email'] : '';
            $value = isset($values['email']) ? $values['email'] : ''?>
            <input class="form__input <?=$class_name;?>" type="text" name="email" id="email" value="<?=$value;?>" placeholder="Введите e-mail">
            <p class="form__message"><?=$error_message;?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>
            <?php $class_name = isset($errors['password']) ? 'form__input--error' : '';
            $error_message = isset($errors['password']) ? $errors['password'] : '';
            $value = isset($values['password']) ? $values['password'] : ''?>
            <input class="form__input <?=$class_name;?>" type="password" name="password" id="password" value="<?=$value;?>" placeholder="Введите пароль">
            <p class="form__message"><?=$error_message;?></p>
        </div>

        <input hidden name="origin" value="<?=$origin;?>">

        <div class="form__row form__row--controls">
            <?php if (isset($errors)):?>
                <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
            <?php endif;?>
            <input class="button" type="submit" name="" value="Войти">
        </div>
    </form>
</div>