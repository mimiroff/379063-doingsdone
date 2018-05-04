<div class="content">
    <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
            <?php
            $counter = 0;
            ?>
            <ul class="main-navigation__list">
                <?php while ($counter < count($categories)) {
                    $class_name = ($counter == 0) ? 'main-navigation__list-item main-navigation__list-item--active' : 'main-navigation__list-item';?>
                    <li class="<?=$class_name;?>">
                        <a class="main-navigation__list-item-link" href="#"><?=$categories[$counter]?></a>
                        <span class="main-navigation__list-item-count"><?=count_projects($tasks, $categories[$counter]);?></span>
                    </li>
                    <?php $counter++; } ?>
            </ul>
        </nav>

        <a class="button button--transparent button--plus content__side-button open-modal"
           href="javascript:;" target="project_add">Добавить проект</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Список задач</h2>

        <form class="search-form" action="index.html" method="post">
            <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

            <input class="search-form__submit" type="submit" name="" value="Искать">
        </form>

        <div class="tasks-controls">
            <nav class="tasks-switch">
                <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                <a href="/" class="tasks-switch__item">Повестка дня</a>
                <a href="/" class="tasks-switch__item">Завтра</a>
                <a href="/" class="tasks-switch__item">Просроченные</a>
            </nav>

            <label class="checkbox">
                <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
                <?php $checked = ($show_complete_tasks == 1) ? "checked" : ""; ?>
                <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?=$checked?>>
                <span class="checkbox__text">Показывать выполненные</span>
            </label>
        </div>
        <?php $counter = 0;?>
        <table class="tasks">
            <?php while ($counter < count($tasks)) {
                $class_name = $tasks[$counter]['is_done'] ? 'tasks__item task task--completed' : 'tasks__item task';
                $hidden = ($show_complete_tasks == 0 && $tasks[$counter]['is_done']) ? 'style="display: none;}"' : '';
                ?>
                <tr class="<?=$class_name;?>" <?=$hidden;?>>
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                            <span class="checkbox__text"><?=htmlspecialchars($tasks[$counter]['task']);?></span>
                        </label>
                    </td>

                    <td class="task__file">
                        <a class="download-link" href="#">Home.psd</a>
                    </td>

                    <td class="task__date"><?=htmlspecialchars($tasks[$counter]['deadline']);?></td>
                    <td class="task__controls"></td>
                </tr>
                <?php $counter++; } ?>
        </table>
    </main>
</div>
