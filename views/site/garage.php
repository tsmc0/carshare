<?php

/** @var yii\web\View $this */
$this->registerMetaTag(['name' => 'description', 'content' => 'CarShare - Каталог автомобилей']);
$this->registerMetaTag(['name' => 'keywords', 'content' => 'CarShare, аренда авто, каталог автомобилей']);

$this->title = 'CarShare - Гараж';
?>
<div class="cars-catalog flex-row">
    <div class='cars-list flex-col car-block'>
        <div class='base-card-head'>
            <?= count($all) ?> ваших авто доступно для аренды
        </div>
        <div class='cars-list-all flex-col'>
            <?php foreach ($all as $item): ?>
                <div class='car-card' id='<?= $item['public_id'] ?>' onclick="selectCar('<?= $item['public_id'] ?>')">
                    <img class='car-card-prev' src="<?= str_replace('_thumb', '', $item['preview']) ?>"
                         alt="<?= $item['mark'] ?>"/>
                    <div class='car-card-info flex-col'>
                        <div class='h-text'><?= $item['mark'] ?> <?= $item['model'] ?></div>
                        <div class='t-text'><?= $item['coast_per_hour'] ?>₽/час</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class='car-details flex-col'>
        <div class='base-card-head'>Сведения</div>
        <div class='car-det flex-col fade-in-left' id='CD' style="display: none">
            <div class="img-wrap">
                <img class='car-det-prev' src='' alt="prev" id='CP'>
                <div class='img-wrap-dx'>Изображение из каталога</div>
            </div>
            <div class='auto-param'>
                <div class="auto-param-name">Марка/Модель</div>
                <div class='h-text' id='CN'></div>
            </div>
            <div class='auto-param'>
                <div class="auto-param-name">Цена аренды в час</div>
                <div class='h-text' id='CC'></div>
            </div>
            <iframe class='map-tx'
                    src="https://yandex.ru/map-widget/v1/?um=constructor%3Ada4ff6cc32b5da79d74310539d8770be0b5ff6d67c40bbf7b4aff63fc43b687a&amp;source=constructor"
                    width="100%" height="200" frameborder="0"></iframe>
            <div class='auto-param'>
                <div class="auto-param-name">Удалённость</div>
                <div class='h-text' id='CC'>400 метров от Вас</div>
            </div>

        </div>
    </div>
</div>
<script>
    const d = new Date();

    let selectedCAR;
    let lognINHOURS;
    let selected;
    let car;

    document.addEventListener('load', () => {
        selected = moment().format('L');
    })

    document.getElementById('BRON').addEventListener('click', () => {
        const d = new Date();

        if (confirm(`
        Вы собираетесь арендовать ${car.mark} ${car.model}, ${moment().format('L')} на ${lognINHOURS} час(ов) на сумму ${Number(Number(car.coast_per_hour) * Number(document.getElementById('DD').value))}₽
        `)) {

            const body = {
                'date_take': moment().subtract(10, 'days').calendar(),
                'auto': selectedCAR,
                'long_in_hours': lognINHOURS,
            };

            const formDescription = {
                'url': WRITE_RENT,
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

                if (res) {
                    redirect('home')
                }
            })
        }
    })

    document.getElementById('DD').addEventListener('change', () => {
        gid('SUM').textContent = Number(Number(car.coast_per_hour) * Number(document.getElementById('DD').value)) + `₽ за ${document.getElementById('DD').value} час(ов)`
        lognINHOURS = document.getElementById('DD').value;
    })

    setTimeout(() => {
        document.querySelectorAll('td').forEach((item) => {
            item.addEventListener('click', () => {
                selected = item.textContent;

            })
        })
    }, 800)


    function selectCar(id) {
        document.querySelectorAll('.sl').forEach((item) => item.classList.remove('sl'))

        gid(id).classList.add('sl');

        const body = {
            'publicID': id,
        };

        const formDescription = {
            'url': CAR_INFO,
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
            gid('CP').src = res.preview.replace('_thumb', '');
            gid('CN').textContent = `${res.mark} ${res.model}`;
            gid('CC').textContent = `${res.coast_per_hour}₽/час`;

            car = res;

            selectedCAR = car.id;

        });
    }
</script>
