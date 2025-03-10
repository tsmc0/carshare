<?php

/** @var yii\web\View $this */
$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Каталог автомобилей']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, аренда авто, каталог автомобилей']);

$this->title = 'CarShare - Группы';
?>
<div class="cars-catalog flex-row">
    <div class='cars-list flex-col car-block'>
        <div class='base-card-head'>
            Группы
            <a class="btn btn-primary" href="<?= \yii\helpers\Url::to('create-group') ?>">Создать группу</a>
        </div>
        <div class='cars-list-all flex-col'>
            <?php foreach ($groups as $item): ?>
                <div class='group' onclick="selectGroup('<?= $item['info']['id'] ?>')">
                    <div class='h-text'><?= $item['info']['title'] ?></div>
                    <div class='group-users flex-row'>
                        <?php foreach ($item['users'] as $user): ?>
                            <?php $fullName = mb_substr($user->first_name, 0, 1) ?>
                            <div class='group-users-ava'><?= mb_strtoupper($fullName) ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class='car-details flex-col'>
        <div class='base-card-head'>Сведения</div>
        <div class='car-det flex-col fade-in-left' id='CD' style="display: none">
            <div class='auto-param'>
                <div class="auto-param-name">Название группы</div>
                <div class='h-text' id='CN'></div>
            </div>
            <div class='auto-param'>
                <div class="auto-param-name">Ссылка-приглашение</div>
                <div class='h-text' id='CU'></div>
                <div class='auto-param-name'>Поделитесь ссылкой со своими друзьями/знакомыми/коллегами и получите
                    возможность совместно арендовать авто
                </div>
            </div>
            <div class='group-content flex-col'>
                <div class="h-text">Участники</div>
                <div class='group-content-wrap flex-col' id='UIG'></div>
            </div>
            <div class='group-content flex-col'>
                <div class="h-text">Авто</div>
                <div class='group-content-wrap flex-col' id='AIG'></div>
            </div>
            <div class='flex-row btns-ctrl'>
                <a id = 'addAuto' class='btn btn-primary'>Добавить авто</a>
            </div>
        </div>
    </div>
</div>
<script>

    function selectGroup(id) {
        document.querySelectorAll('.sl').forEach((item) => item.classList.remove('sl'))

        const body = {
            'publicID': id,
        };

        const formDescription = {
            'url': GROUP_INFO,
            'params': {
                'method': 'post',
                'body': JSON.stringify(body),
                'headers': {
                    'content-type': 'application/json;charset=utf8;',
                }
            }
        }

        bindFormSend(formDescription, (res) => {
            console.log(res)

            gid('CD').style.display = 'flex';
            gid('CN').textContent = `${res.data.title}`;
            gid('UIG').replaceChildren();

            res.users.forEach((item) => {
                const a = document.createElement('div')
                a.textContent = `${String(item.second_name).substring(0, 1).toUpperCase()}${String(item.first_name).substring(0, 1).toUpperCase()}`
                a.classList.add('group-item-user-ava')
                a.classList.add('flex-row')

                const n = document.createElement('group-item-user')
                n.textContent = `${item.second_name} ${item.first_name}`

                const w = document.createElement('div')
                w.classList.add('group-item-user')
                w.classList.add('flex-row')
                w.appendChild(a)
                w.appendChild(n)

                gid('UIG').appendChild(w)
            })

            res.cars.forEach((item) => {
                const n = document.createElement('group-item-user')
                n.textContent = `${item.mark} ${item.model}`

                const w = document.createElement('div')
                w.classList.add('group-item-auto')
                w.classList.add('flex-row')
                w.appendChild(n)

                gid('AIG').appendChild(w)
            })

            const location = window.location;

            gid('CU').textContent = `${location.origin}/web/invite-${res.data.public_id}`;

            gid('addAuto').addEventListener('click', () => {
                redirect(`group-${res.data.id}/group-car-add`)
            })

        });
    }
</script>
