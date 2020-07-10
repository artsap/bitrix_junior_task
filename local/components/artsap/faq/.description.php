<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("FAQ"),
	"DESCRIPTION" => GetMessage("FAQ_DESC"),
	"SORT" => 10,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "artsap",
		"CHILD" => array(
			"ID" => "faq",
			"NAME" => GetMessage("DESC_FAQ"),
			"SORT" => 10,
			"CHILD" => array(
				"ID" => "faq",
			),
		),
	),
);

?>