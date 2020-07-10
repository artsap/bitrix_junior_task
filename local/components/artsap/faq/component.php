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

Loader::includeModule('iblock');

if ($arParams['JQERY'] == 'Y'):
    CJSCore::Init(['jquery']);
endif;

$rs = ElementTable::getList(array(
        'order' => array('SORT' => 'ASC'), // сортировка
        'select' => array('ID', 'NAME', 'IBLOCK_ID', 'SORT', 'TAGS'), // выбираемые поля, без свойств. Свойства можно получать на старом ядре \CIBlockElement::getProperty
        'filter' => array('IBLOCK_ID' => $arParams['IBLOCK_ID']), // фильтр только по полям элемента, свойства (PROPERTY) использовать нельзя
        'group' => array(), // группировка по полю, order должен быть пустой
        'limit' => 2, // целое число, ограничение выбираемого кол-ва
    )
);

while ($r = $rs->fetch()) {
    $arResult[] = $r;
}

$this->IncludeComponentTemplate();
