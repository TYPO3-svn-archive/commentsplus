<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_commentsplus_domain_model_comment'] = array(
	'ctrl' => $TCA['tx_commentsplus_domain_model_comment']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, time, email',
	),
	'types' => array(
		'1' => array('showitem' => '
			sys_language_uid;;;;1-1-1,
			l10n_parent,
			l10n_diffsource,
			--palette--;Author;author,
			--palette--;Spam & Reputation;spam,
			--palette--;Post;post'
		),
	),
	'palettes' => array(
		'author' => array(
			'canNotCollapse' => 1,
			'showitem' => 'name, email, --linebreak--, website, ip'
		),
		'post' => array(
			'canNotCollapse' => 1,
			'showitem' => 'time, --linebreak--, message'
		),
        'spam' => array(
			'canNotCollapse' => 1,
			'showitem' => 'approved, --linebreak--, reputation'
		),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'time' => array(
			'label' => 'LLL:EXT:commentsplus/Resources/Private/Language/locallang_db.xml:tx_commentsplus_domain_model_comment.time',
			'config' => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'name' => array(
			'label' => 'LLL:EXT:commentsplus/Resources/Private/Language/locallang_db.xml:tx_commentsplus_domain_model_comment.name',
			'config' => array(
				'type' => 'input',
                'size' => 20
			)
		),
		'email' => array(
			'label' => 'LLL:EXT:commentsplus/Resources/Private/Language/locallang_db.xml:tx_commentsplus_domain_model_comment.email',
			'config' => array(
				'type' => 'input',
                'size' => 20,
			)
		),
        'website' => array(
			'label' => 'LLL:EXT:commentsplus/Resources/Private/Language/locallang_db.xml:tx_commentsplus_domain_model_comment.website',
			'config' => array(
				'type' => 'input',
                'size' => 20,
			)
		),
		'message' => array(
			'label' => 'LLL:EXT:commentsplus/Resources/Private/Language/locallang_db.xml:tx_commentsplus_domain_model_comment.message',
			'config' => array(
				'type' => 'text'
			)
		),
        'ip' => array(
            'label' => 'LLL:EXT:commentsplus/Resources/Private/Language/locallang_db.xml:tx_commentsplus_domain_model_comment.ip',
			'config' => array(
				'type' => 'none',
                'size' => 20,
			)
        ),
        'approved' => array(
            'label' => 'LLL:EXT:commentsplus/Resources/Private/Language/locallang_db.xml:tx_commentsplus_domain_model_comment.approved',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array(
						'Not approved yet',
						Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_NOTAPPROVED,
						'EXT:commentsplus/Resources/Public/Icons/approval_status_notapproved.png'
					),
					array(
						'Approved',
						Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_APPROVED,
						'EXT:commentsplus/Resources/Public/Icons/approval_status_approved.png'
					),
					array(
						'Spam',
						Tx_Commentsplus_Domain_Model_Comment::APPROVAL_STATUS_SPAM,
						'EXT:commentsplus/Resources/Public/Icons/approval_status_spam.png'
					),
				)
			)
        ),
		'reputation' => array(
			'label' => 'Reputation',
			'config' => array (
				'type' => 'user',
				'userFunc' => 'EXT:commentsplus/Classes/Utility/Userfunc.php:Tx_Commentsplus_Utility_Userfunc->reputationField',
			),
		),
	),
);
?>