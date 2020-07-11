<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

?>
<? if ($arResult['ERROR']): ?>
    <div class="arrors">
        <? foreach ($arResult['ERROR'] as $error): ?>
            <?= $error; ?><br>
        <? endforeach; ?>
    </div>
<? endif; ?>
<? if ($arResult['SUCCESS']): ?>
    <div class="success">
        <?= $arResult['SUCCESS']; ?>
    </div>
<? endif; ?>
    <form action="<?= $_SERVER['REQUEST_URI']; ?>" id="faq" method="post">
        <input name="action" type="hidden" value="add">
        <div class="fBit">
            <input placeholder="Имя *" type="text" name="NAME" value="<?= htmlspecialchars($_POST['NAME']); ?>">
        </div>
        <div class="fBit">
            <input placeholder="Фамилия" type="text" name="SURNAME" value="<?= htmlspecialchars($_POST['SURNAME']); ?>">
        </div>
        <div class="fBit">
            <input placeholder="E-mail *" type="email" name="EMAIL" value="<?= htmlspecialchars($_POST['EMAIL']); ?>">
        </div>
        <div class="fBit">
            <input placeholder="Tелефон *" type="tel" name="PHONE" value="<?= htmlspecialchars($_POST['PHONE']); ?>">
        </div>
        <div class="fBit">
            <textarea placeholder="Текст сообщения *" name="TEXT" id="text" cols="30" rows="10"><?= htmlspecialchars($_POST['TEXT']); ?></textarea>
        </div>
        <? if ($arParams['CAPTCHA'] == 'Y'): ?>
            <div class="fBit">
                <div class="g-recaptcha" data-sitekey="<?= $arResult['CAPTCHA1']; ?>"></div>
            </div>
        <? endif; ?>
        <div class="fBit">
            * Поля обязательные для заполнения.
        </div>
        <div class="fBit">
            <input type="submit" value="Отправить">
        </div>
    </form>
<? if ($arResult['ITEMS']): ?>
    <? foreach ($arResult['ITEMS'] as $item): ?>
        <div class="faqBit">
            <h3><?= $item['NAME']; ?></h3>
            <?= $item['PREVIEW_TEXT']; ?>
            <div class="clear"></div>
        </div>

    <? endforeach; ?>
<? endif; ?>
<? /*
global $USER;
if ($USER->IsAdmin()):
    echo '<pre>';
    print_r($arResult);
    echo '</pre>';
endif; */
?>