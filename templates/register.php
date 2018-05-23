<div class="content">
        <section class="content__side">
          <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

          <a class="button button--transparent content__side-button" href="#">Войти</a>
        </section>

        <main class="content__main">
          <h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" action="register.php" method="post">
            <div class="form__row">
              <label class="form__label" for="email">E-mail <sup>*</sup></label>
                <?php $class_name = isset($errors['email']) ? 'form__input--error' : '';
                $error_message = isset($errors['email']) ? $errors['email'] : '';
                $value = isset($values['email']) ? $values['email'] : ''?>
              <input class="form__input <?=$class_name?>" type="text" name="email" id="email" value="<?=$value;?>" placeholder="Введите e-mail">

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

            <div class="form__row">
              <label class="form__label" for="name">Имя <sup>*</sup></label>
                <?php $class_name = isset($errors['name']) ? 'form__input--error' : '';
                $error_message = isset($errors['name']) ? $errors['name'] : '';
                $value = isset($values['name']) ? $values['name'] : ''?>
              <input class="form__input" type="text" name="name" id="name" value="<?=$value;?>" placeholder="Введите имя">
              <p class="form__message"><?=$error_message;?></p>
            </div>

            <div class="form__row form__row--controls">
              <?php if (isset($errors)):?>
                <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
              <?php endif;?>
              <input class="button" type="submit" name="" value="Зарегистрироваться">
            </div>
          </form>
        </main>
      </div>
    </div>
  </div>