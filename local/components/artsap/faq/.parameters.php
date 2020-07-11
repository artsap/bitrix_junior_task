<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arCurrentValues */

if (!CModule::IncludeModule("iblock"))
    return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-" => " "));

$arIBlocks = array();
$db_iblock = CIBlock::GetList(array("SORT" => "ASC"), array("SITE_ID" => $_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")));
while ($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = "[" . $arRes["ID"] . "] " . $arRes["NAME"];

$arSorts = array("ASC" => GetMessage("T_IBLOCK_DESC_ASC"), "DESC" => GetMessage("T_IBLOCK_DESC_DESC"));

$arComponentParameters = array(
    "GROUPS" => array(),
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("IBLOCK_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => '={$_REQUEST["ID"]}',
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ),
        'JQERY' => array(
            'NAME' => GetMessage("JQERY"),
            'TYPE' => 'CHECKBOX',
            'PARENT' => 'BASE',
        ),
        'COUNT' => array(
            'NAME' => GetMessage("COUNT"),
            'TYPE' => 'STRING',
            'PARENT' => 'BASE',
            "DEFAULT" => '5',
        ),
        'CAPTCHA' => array(
            'NAME' => GetMessage("CAPTCHA"),
            'TYPE' => 'CHECKBOX',
            'PARENT' => 'BASE',
        ),
        'CAPTCHA1' => array(
            'NAME' => GetMessage("CAPTCHA1"),
            'TYPE' => 'STRING',
            'PARENT' => 'BASE',
        ),
        'CAPTCHA2' => array(
            'NAME' => GetMessage("CAPTCHA2"),
            'TYPE' => 'STRING',
            'PARENT' => 'BASE',
        ),
    ),
);