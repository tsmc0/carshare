<?php

/** @var yii\web\View $this */
$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Каталог автомобилей']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, аренда авто, каталог автомобилей']);

$this->title = 'CarShare - Приглашение в группу';
?>
<div class="all-mid flex-col">
    <div class='modal'>
        <div class='inv-name'>
            <div class='t-text'>Вас пригласили в группу</div>
            <div class='h-text'>«<?= $invite['title'] ?>»</div>
        </div>
        <div class='modal-ctrl'>
            <button class='btn btn-primary' onclick="acceptInvite('<?= $invite['public_id'] ?>')">Принять приглашение</button>
            <div class='t-text'>Участников в группе - <?= $users ?></div>
        </div>
    </div>
</div>
<script>
    function acceptInvite(id) {
        const body = {
            'publicID': id,
        };

        const formDescription = {
            'url': ACCEPT_INVITE,
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

            if (res.message === true) {
                redirect('group')
            } else {
                alert(res.message)
            }

        });
    }
</script>
