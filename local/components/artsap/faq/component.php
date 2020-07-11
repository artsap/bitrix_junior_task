<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */

/** @global CMain $APPLICATION */

use Bitrix\Iblock;
use Bitrix\Iblock\ElementTable as ElementTable;
use Bitrix\Main\Loader as Loader;
use Bitrix\Main\Page\Asset as Asset;
use Bitrix\Main\UI\PageNavigation as PageNavigation;

$COUNT = $arParams['COUNT'];
$IBLOCK_ID = $arParams['IBLOCK_ID'];
$arResult['CAPTCHA1'] = $arParams['CAPTCHA1'];
$CAPTCHA2 = $arParams['CAPTCHA2'];

Loader::includeModule('iblock');

if ($arParams['JQERY'] == 'Y')
    CJSCore::Init(['jquery']);

if ($arParams['CAPTCHA'] == 'Y')
    Asset::getInstance()->addJs('https://www.google.com/recaptcha/api.js');

if ($_POST['action'] == 'add') {

    if (!empty($_POST['PHONE']) && !empty($_POST['EMAIL']) && !empty($_POST['TEXT']) && !empty($_POST['NAME'])) {

        if ($arParams['CAPTCHA'] == 'Y') {
            global $APPLICATION;
            if ($_POST['g-recaptcha-response']) {
                $httpClient = new \Bitrix\Main\Web\HttpClient;
                $result = $httpClient->post(
                    'https://www.google.com/recaptcha/api/siteverify',
                    array(
                        'secret' => $CAPTCHA2,
                        'response' => $_POST['g-recaptcha-response'],
                        'remoteip' => $_SERVER['HTTP_X_REAL_IP']
                    )
                );
                $result = json_decode($result, true);
                if ($result['success'] !== true) {
                    $arResult['ERROR'][] = GetMessage("ERROR1");
                }
            } else {
                $arResult['ERROR'][] = GetMessage("ERROR1");
            }
        }

        if (!filter_var($_POST['EMAIL'], FILTER_VALIDATE_EMAIL)) {
            $arResult['ERROR'][] = GetMessage("ERROR2");
        }

        if (!preg_match('!^\+7 \(\d{3}\) \d{3}(-\d{2}){2}$!', $_POST['PHONE'])) {
            $arResult['ERROR'][] = GetMessage("ERROR3");
        }

        if (!is_array($arResult['ERROR'])) {

            $NAME = trim(htmlspecialchars($_POST['NAME'])) . ' ' . trim(htmlspecialchars($_POST['SURNAME']));
            $EMAIL = trim(htmlspecialchars($_POST['EMAIL']));
            $PHONE = trim(htmlspecialchars($_POST['PHONE']));
            $TEXT = trim(htmlspecialchars($_POST['TEXT']));
            $INFO = $NAME . '
' . $PHONE . '
' . $EMAIL;

            $el = new CIBlockElement;

            $arLoadProductArray = array(
                "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
                "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
                "IBLOCK_ID" => $IBLOCK_ID,
                "NAME" => $NAME,
                "ACTIVE" => "N",            // активен
                "PREVIEW_TEXT" => $TEXT,
                "DETAIL_TEXT" => $INFO,
            );

            if ($PRODUCT_ID = $el->Add($arLoadProductArray))
                $arResult['SUCCESS'] = GetMessage("SUCCESS");
            else
                $arResult['ERROR'][] = $el->LAST_ERROR;
        }
    } else {
        $arResult['ERROR'][] = GetMessage("ERROR4");
    }
}

$nav = new PageNavigation("nav");
$nav->allowAllRecords(true)
    ->setPageSize($COUNT)
    ->initFromUri();

$rs = ElementTable::getList(array(
        'order' => array('ID' => 'DESC'), // сортировка
        'select' => array('NAME', 'PREVIEW_TEXT'),
        'filter' => array('IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y'),
        "count_total" => true,
        "offset" => $nav->getOffset(),
        "limit" => $nav->getLimit(),
    )
);

while ($r = $rs->fetch()) {
    $arResult['ITEMS'][] = $r;
}

$this->IncludeComponentTemplate();

$nav->setRecordCount($rs->getCount());

$APPLICATION->IncludeComponent(
    "bitrix:main.pagenavigation",
    ".default",
    array(
        "NAV_OBJECT" => $nav,
        "COMPONENT_TEMPLATE" => ".default"
    ),
    false
);
