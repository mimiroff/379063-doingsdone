<div class="content">
    <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <?php $class_name = ($active == 0) ? 'main-navigation__list-item  main-navigation__list-item--active' : 'main-navigation__list-item';?>
                <li class="<?=$class_name;?>">
                    <a class="main-navigation__list-item-link" href="index.php?id=0">Входящие</a>
                    <span class="main-navigation__list-item-count"><?=count_inbox_tasks_by_user($link, $user['id'])?></span>
                </li>
                <?php foreach($projects as $project) {
                    $class_name = ($active == $project['id']) ? 'main-navigation__list-item  main-navigation__list-item--active' : 'main-navigation__list-item';?>
                    <li class="<?=$class_name;?>">
                        <a class="main-navigation__list-item-link" href="index.php?id=<?=$project['id'];?>"><?=$project['project_name']?></a>
                        <span class="main-navigation__list-item-count"><?=count_tasks_by_project($link, $project['id']);?></span>
                    </li>
                    <?php }; ?>
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
                <?php foreach($filters as $counter => $filter) {
                $class_name = ($active_filter == $counter) ? 'tasks-switch__item tasks-switch__item--active' : 'tasks-switch__item';?>
                <a href="index.php?filter=<?=$counter;?>" class="<?=$class_name;?>"><?=$filter;?></a>
                <?php }; ?>
            </nav>

            <label class="checkbox">
                <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
                <?php $checked = ($show_complete_tasks == 1) ? "checked" : ""; ?>
                <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?=$checked?>>
                <span class="checkbox__text">Показывать выполненные</span>
            </label>
        </div>
        <table class="tasks">
            <?php foreach ($tasks as $task) {
                $class_name = $task['end_date'] ? 'tasks__item task task--completed' : 'tasks__item task';
                $hidden = ($show_complete_tasks == 0 && $task['end_date']) ? 'style="display: none;}"' : '';
                $important = ($task['deadline'] == null) ? '' : (count_deadline($task['deadline'], 86400)) ? 'task--important' : '';
                $checked = $task['end_date'] ? 'checked' : '';
                ?>
                <tr class="<?=$class_name;?> <?=$important;?>" <?=$hidden;?>>
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden task__checkbox" <?=$checked;?> type="checkbox" value="<?=$task['id'];?>">
                            <span class="checkbox__text"><?=htmlspecialchars(strip_tags($task['task_name']));?></span>
                        </label>
                    </td>

                    <td class="task__file">
                        <?php if ($task['file_path'] == null) :?>
                        <a class="download-link">Нет</a>
                        <?php else:?>
                        <a class="download-link" href="<?=$task['file_path'];?>" download><?=htmlspecialchars($task['file_name']);?></a>
                        <?php endif;?>
                    </td>
                    <?php $date = ($task['deadline'] == null) ? 'Нет' : date('d.m.Y', strtotime(htmlspecialchars($task['deadline'])));?>
                    <td class="task__date"><?=$date;?></td>
                    <td class="task__controls"></td>
                </tr>
                <?php }; ?>
        </table>
    </main>
</div>
</div>
</div>
