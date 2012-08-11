<?php

	// index.php - Version 1.01

	// Table headers
	define('_AM_TWEETBOMB_TH_ACTIONS','Actions');
	define('_AM_TWEETBOMB_TH_CID','Campaign ID');
	define('_AM_TWEETBOMB_TH_NAME','Name');
	define('_AM_TWEETBOMB_TH_DESCRIPTION','Description');
	define('_AM_TWEETBOMB_TH_START','Start Time');
	define('_AM_TWEETBOMB_TH_END','End Time');
	define('_AM_TWEETBOMB_TH_TIMED','Timed');
	define('_AM_TWEETBOMB_TH_UID','User');
	define('_AM_TWEETBOMB_TH_CREATED','Created');
	define('_AM_TWEETBOMB_TH_ACTIONED','Actioned');
	define('_AM_TWEETBOMB_TH_UPDATED','Updated');
	define('_AM_TWEETBOMB_TH_CATID','Category ID');
	define('_AM_TWEETBOMB_TH_PCATDID','Parent Category ID');
	define('_AM_TWEETBOMB_TH_KID','Keyword ID');
	define('_AM_TWEETBOMB_TH_BASE','Phrase Base');
	define('_AM_TWEETBOMB_TH_KEYWORD','Keyword/phrase');
	define('_AM_TWEETBOMB_TH_BASEID','Base ID');
	define('_AM_TWEETBOMB_TH_BASE1','Base A');
	define('_AM_TWEETBOMB_TH_BASE2','Base B');
	define('_AM_TWEETBOMB_TH_BASE3','Base C');
	define('_AM_TWEETBOMB_TH_BASE4','Base D');
	define('_AM_TWEETBOMB_TH_BASE5','Base E');
	define('_AM_TWEETBOMB_TH_BASE6','Base F');
	define('_AM_TWEETBOMB_TH_BASE7','Base G');
	define('_AM_TWEETBOMB_TH_TID','Tweeter ID');
	define('_AM_TWEETBOMB_TH_TWITTER_USERNAME','Twitter Username');
	define('_AM_TWEETBOMB_TH_URLID','URL ID');

	// Admin redirection messages responses
	define('_AM_MSG_CAMPAIGN_FAILEDTOSAVE','Campaign Failed to Save!');
	define('_AM_MSG_CAMPAIGN_SAVEDOKEY','Campaign Saved Okey!');
	define('_AM_MSG_CAMPAIGN_FAILEDTODELETE','Campaign Failed to Delete.');
	define('_AM_MSG_CAMPAIGN_DELETED','Campaign Deleted');
	define('_AM_MSG_CAMPAIGN_DELETE','Do you wish to delete the campaign "%s"?');
	define('_AM_MSG_CATEGORY_FAILEDTOSAVE','Category Failed to Save!');
	define('_AM_MSG_CATEGORY_SAVEDOKEY','Category Saved Okey!');
	define('_AM_MSG_CATEGORY_FAILEDTODELETE','Category Failed to Delete.');
	define('_AM_MSG_CATEGORY_DELETED','Category Deleted');
	define('_AM_MSG_CATEGORY_DELETE','Do you wish to delete the category "%s"?');
	define('_AM_MSG_KEYWORDS_FAILEDTOSAVE','Keywords Failed to Save!');
	define('_AM_MSG_KEYWORDS_SAVEDOKEY','Keywords Saved Okey!');
	define('_AM_MSG_KEYWORDS_FAILEDTODELETE','Keywords Failed to Delete.');
	define('_AM_MSG_KEYWORDS_DELETED','Keywords Deleted');
	define('_AM_MSG_KEYWORDS_DELETE','Do you wish to delete the keyphrase "%s"?');
	define('_AM_MSG_BASEMATRIX_FAILEDTOSAVE','Sentence Matrix Failed to Save!');
	define('_AM_MSG_BASEMATRIX_SAVEDOKEY','Sentence Matrix Saved Okey!');
	define('_AM_MSG_BASEMATRIX_FAILEDTODELETE','Sentence Matrix Failed to Delete.');
	define('_AM_MSG_BASEMATRIX_DELETED','Sentence Matrix Deleted');
	define('_AM_MSG_BASEMATRIX_DELETE','Do you wish to delete the sentence matrix "%s"?');
	define('_AM_MSG_USERNAMES_FAILEDTOSAVE','Username Failed to Save!');
	define('_AM_MSG_USERNAMES_SAVEDOKEY','Username Saved Okey!');
	define('_AM_MSG_USERNAMES_FAILEDTODELETE','Username Failed to Delete.');
	define('_AM_MSG_USERNAMES_DELETED','Username Deleted');
	define('_AM_MSG_USERNAMES_DELETE','Do you wish to delete the username "%s"?');
	define('_AM_MSG_URLS_FAILEDTOSAVE','URLs Failed to Save!');
	define('_AM_MSG_URLS_SAVEDOKEY','URLs Saved Okey!');
	define('_AM_MSG_URLS_FAILEDTODELETE','URLs Failed to Delete.');
	define('_AM_MSG_URLS_DELETED','URLs Deleted');
	define('_AM_MSG_URLS_DELETE','Do you wish to delete the URL "%s"?');
	define('_AM_MSG_SCHEDULER_FAILEDTOSAVE','Scheduled Tweet Failed to Save!');
	define('_AM_MSG_SCHEDULER_SAVEDOKEY','Scheduled Tweet Saved Okey!');
	define('_AM_MSG_SCHEDULER_FAILEDTODELETE','Scheduled Tweet Failed to Delete.');
	define('_AM_MSG_SCHEDULER_DELETED','Scheduled Tweet Deleted');
	define('_AM_MSG_SCHEDULER_DELETE','Do you wish to delete the category "%s"?');	
	define('_AM_MSG_SCHEDULER_IMPORT_FAILED','Scheduled Tweet Failed to Import Correctly!');
	define('_AM_MSG_SCHEDULER_IMPORT_SUCCESSFUL','Scheduled Tweet Tweet Succesfully Imported Correctly!');
	
	//Smarty Template Definitions
	define('_AM_TWEETBOMB_EDITNEW_BASEMATRIX_H1','Edit/New Sentence Matrix');
	define('_AM_TWEETBOMB_EDITNEW_BASEMATRIX_P','From here you can create or edit in full your campaign.');
	define('_AM_TWEETBOMB_BASEMATRIX_H1','Sentence Matrixs');
	define('_AM_TWEETBOMB_BASEMATRIX_P','From here you can browse and edit your Sentence Matrix paginated.');
	define('_AM_TWEETBOMB_NEW_BASEMATRIX_H1','New Sentence Matrix');
	define('_AM_TWEETBOMB_NEW_BASEMATRIX_P','Create a new Sentence Matrix');
	define('_AM_TWEETBOMB_EDITNEW_CAMPAIGN_H1','Edit/New Campaign');
	define('_AM_TWEETBOMB_EDITNEW_CAMPAIGN_P','From here you can create or edit in full your campaign.');
	define('_AM_TWEETBOMB_CAMPAIGN_H1','Campaigns');
	define('_AM_TWEETBOMB_CAMPAIGN_P','From here you can browse and edit your campaigns paginated.');
	define('_AM_TWEETBOMB_NEW_CAMPAIGN_H1','New Campaign');
	define('_AM_TWEETBOMB_NEW_CAMPAIGN_P','Create a new Campaign');
	define('_AM_TWEETBOMB_EDITNEW_CATEGORY_H1','Edit/New Category');
	define('_AM_TWEETBOMB_EDITNEW_CATEGORY_P','From here you can create or edit in full your category!');
	define('_AM_TWEETBOMB_CATEGORY_H1','Categories');
	define('_AM_TWEETBOMB_CATEGORY_P','From here you can browse and edit some of the details for categories.');
	define('_AM_TWEETBOMB_NEW_CATEGORY_H1','New Category');
	define('_AM_TWEETBOMB_NEW_CATEGORY_P','Create a new Category');
	define('_AM_TWEETBOMB_EDITNEW_KEYWORDS_H1','Edit/New Keywords');
	define('_AM_TWEETBOMB_EDITNEW_KEYWORDS_P','From here you can edit or create a new keyword for a base of a phrase in a sentence.');
	define('_AM_TWEETBOMB_KEYWORDS_H1','Keywords/Key Phrases');
	define('_AM_TWEETBOMB_KEYWORDS_P','From here you can browse and edit the components of the tweet sentence.');
	define('_AM_TWEETBOMB_NEW_KEYWORDS_H1','New Keyword/Phrase');
	define('_AM_TWEETBOMB_NEW_KEYWORDS_P','Create a new phrase for a campaign or category.');
	define('_AM_TWEETBOMB_EDITNEW_URLS_H1','Edit/New URL');
	define('_AM_TWEETBOMB_EDITNEW_URLS_P','From here you can browse your URLs and edit or create new ones, remember for a URL %s will be replaced with the tweet string.');
	define('_AM_TWEETBOMB_URLS_H1','URL\'s');
	define('_AM_TWEETBOMB_URLS_P','From here you can browse or edit your URL for the feed.');
	define('_AM_TWEETBOMB_NEW_URLS_H1','New URL');
	define('_AM_TWEETBOMB_NEW_URLS_P','Create new tweet URL.');
	define('_AM_TWEETBOMB_EDITNEW_USERNAMES_H1','Edit/New Twitter Username');
	define('_AM_TWEETBOMB_EDITNEW_USERNAMES_P','From here you can edit or create a new twitter username');
	define('_AM_TWEETBOMB_USERNAMES_H1','Twitter Usernames');
	define('_AM_TWEETBOMB_USERNAMES_P','These are the twitter usernames you have on this installation.');
	define('_AM_TWEETBOMB_NEW_USERNAMES_H1','New Twitter Username');
	define('_AM_TWEETBOMB_NEW_USERNAMES_P','Create new Twitter Username');
	
	//Forms Definitions
	define('_AM_TWEETBOMB_FORM_ISNEW_BASEMATRIX','New Sentence Matrix');
	define('_AM_TWEETBOMB_FORM_EDIT_BASEMATRIX','Edit Sentence Matrix');
	define('_AM_TWEETBOMB_FORM_CID_BASEMATRIX','Campaign for this Matrix');
	define('_AM_TWEETBOMB_FORM_DESC_CID_BASEMATRIX','');
	define('_AM_TWEETBOMB_FORM_CATID_BASEMATRIX','Category for this Matrix');
	define('_AM_TWEETBOMB_FORM_DESC_CATID_BASEMATRIX','');
	define('_AM_TWEETBOMB_FORM_BASEA_BASEMATRIX','Phrase A');
	define('_AM_TWEETBOMB_FORM_DESC_BASEA_BASEMATRIX','');
	define('_AM_TWEETBOMB_FORM_BASEB_BASEMATRIX','Phrase B');
	define('_AM_TWEETBOMB_FORM_DESC_BASEB_BASEMATRIX','');
	define('_AM_TWEETBOMB_FORM_BASEC_BASEMATRIX','Phrase C');
	define('_AM_TWEETBOMB_FORM_DESC_BASEC_BASEMATRIX','');
	define('_AM_TWEETBOMB_FORM_BASED_BASEMATRIX','Phrase D');
	define('_AM_TWEETBOMB_FORM_DESC_BASED_BASEMATRIX','');
	define('_AM_TWEETBOMB_FORM_BASEE_BASEMATRIX','Phrase E');
	define('_AM_TWEETBOMB_FORM_DESC_BASEE_BASEMATRIX','');
	define('_AM_TWEETBOMB_FORM_BASEF_BASEMATRIX','Phrase F');
	define('_AM_TWEETBOMB_FORM_DESC_BASEF_BASEMATRIX','');
	define('_AM_TWEETBOMB_FORM_BASEG_BASEMATRIX','Phrase G');
	define('_AM_TWEETBOMB_FORM_DESC_BASEG_BASEMATRIX','');
	define('_AM_TWEETBOMB_FORM_UID_BASEMATRIX','Created By');
	define('_AM_TWEETBOMB_FORM_CREATED_BASEMATRIX','Created');
	define('_AM_TWEETBOMB_FORM_ACTIONED_BASEMATRIX','Actioned');
	define('_AM_TWEETBOMB_FORM_UPDATED_BASEMATRIX','Updated');
	define('_AM_TWEETBOMB_FORM_ISNEW_CAMPAIGN','New Campaign');
	define('_AM_TWEETBOMB_FORM_EDIT_CAMPAIGN','Edit Campaign');
	define('_AM_TWEETBOMB_FORM_CATID_CAMPAIGN','Category for Campaign');
	define('_AM_TWEETBOMB_FORM_DESC_CATID_CAMPAIGN','');
	define('_AM_TWEETBOMB_FORM_NAME_CAMPAIGN','Name of Campaign');
	define('_AM_TWEETBOMB_FORM_DESC_NAME_CAMPAIGN','');
	define('_AM_TWEETBOMB_FORM_DESCRIPTION_CAMPAIGN','Description of Campaign');
	define('_AM_TWEETBOMB_FORM_DESC_DESCRIPTION_CAMPAIGN','');
	define('_AM_TWEETBOMB_FORM_START_CAMPAIGN','Campaign Starts');
	define('_AM_TWEETBOMB_FORM_DESC_START_CAMPAIGN','');
	define('_AM_TWEETBOMB_FORM_END_CAMPAIGN','Campaign Ends');
	define('_AM_TWEETBOMB_FORM_DESC_END_CAMPAIGN','');
	define('_AM_TWEETBOMB_FORM_TIMED_CAMPAIGN','Timed Campaign');
	define('_AM_TWEETBOMB_FORM_DESC_TIMED_CAMPAIGN','');
	define('_AM_TWEETBOMB_FORM_UID_CAMPAIGN','Created by');
	define('_AM_TWEETBOMB_FORM_CREATED_CAMPAIGN','Created');
	define('_AM_TWEETBOMB_FORM_UPDATED_CAMPAIGN','Updated');
	define('_AM_TWEETBOMB_FORM_ISNEW_CATEGORY','New Category');
	define('_AM_TWEETBOMB_FORM_EDIT_CATEGORY','Edit Category');
	define('_AM_TWEETBOMB_FORM_PCATID_CATEGORY','Parent Category');
	define('_AM_TWEETBOMB_FORM_DESC_PCATID_CATEGORY','');
	define('_AM_TWEETBOMB_FORM_NAME_CATEGORY','Category Title');
	define('_AM_TWEETBOMB_FORM_DESC_NAME_CATEGORY','');
	define('_AM_TWEETBOMB_FORM_UID_CATEGORY','Created By');
	define('_AM_TWEETBOMB_FORM_CREATED_CATEGORY','Created');
	define('_AM_TWEETBOMB_FORM_UPDATED_CATEGORY','Updated');
	define('_AM_TWEETBOMB_FORM_ISNEW_KEYWORDS','New Keyword/Phrase');
	define('_AM_TWEETBOMB_FORM_EDIT_KEYWORDS','Edit Keyword/Phrase');
	define('_AM_TWEETBOMB_FORM_CID_KEYWORDS','Campaign Keyword is For');
	define('_AM_TWEETBOMB_FORM_DESC_CID_KEYWORDS',''); 
	define('_AM_TWEETBOMB_FORM_CATID_KEYWORDS','Category Keyword is For');
	define('_AM_TWEETBOMB_FORM_DESC_CATID_KEYWORDS','');
	define('_AM_TWEETBOMB_FORM_BASE_KEYWORDS','Sentence Basis');
	define('_AM_TWEETBOMB_FORM_DESC_BASE_KEYWORDS','');
	define('_AM_TWEETBOMB_FORM_KEYWORD_KEYWORDS','Keyword/Phrase');
	define('_AM_TWEETBOMB_FORM_DESC_KEYWORD_KEYWORDS','');
	define('_AM_TWEETBOMB_FORM_UID_KEYWORDS','Created by');
	define('_AM_TWEETBOMB_FORM_CREATED_KEYWORDS','Created');
	define('_AM_TWEETBOMB_FORM_ACTIONED_KEYWORDS','Actioned');
	define('_AM_TWEETBOMB_FORM_UPDATED_KEYWORDS','Updated');
	define('_AM_TWEETBOMB_FORM_ISNEW_USERNAMES','New Twitter Username');
	define('_AM_TWEETBOMB_FORM_EDIT_USERNAMES','Edit Twitter Username');
	define('_AM_TWEETBOMB_FORM_CID_USERNAMES','Campaign for username');
	define('_AM_TWEETBOMB_FORM_DESC_CID_USERNAMES','');
	define('_AM_TWEETBOMB_FORM_CATID_USERNAMES','Category for username');
	define('_AM_TWEETBOMB_FORM_DESC_CATID_USERNAMES','');
	define('_AM_TWEETBOMB_FORM_USERNAME_USERNAMES','Twitter Username');
	define('_AM_TWEETBOMB_FORM_DESC_USERNAME_USERNAMES','');
	define('_AM_TWEETBOMB_FORM_UID_USERNAMES','Created By');
	define('_AM_TWEETBOMB_FORM_CREATED_USERNAMES','Created');
	define('_AM_TWEETBOMB_FORM_UPDATED_USERNAMES','Updated');
	define('_AM_TWEETBOMB_FORM_ISNEW_URLS','New Search URL');
	define('_AM_TWEETBOMB_FORM_EDIT_URLS','Edit Search URL');
	define('_AM_TWEETBOMB_FORM_CID_URLS','Campaign for URL');
	define('_AM_TWEETBOMB_FORM_DESC_CID_URLS','');
	define('_AM_TWEETBOMB_FORM_CATID_URLS','Category for URL');
	define('_AM_TWEETBOMB_FORM_DESC_CATID_URLS','');
	define('_AM_TWEETBOMB_FORM_SURL_URLS','Search URL');
	define('_AM_TWEETBOMB_FORM_DESC_SURL_URLS','%s will be replace with URL Encoded Sentence');
	define('_AM_TWEETBOMB_FORM_NAME_URLS','Name of URL');
	define('_AM_TWEETBOMB_FORM_DESC_NAME_URLS','');
	define('_AM_TWEETBOMB_FORM_DESCRIPTION_URLS','Description of URL');
	define('_AM_TWEETBOMB_FORM_DESC_DESCRIPTION_URLS','');
	define('_AM_TWEETBOMB_FORM_UID_URLS','Created By');
	define('_AM_TWEETBOMB_FORM_CREATED_URLS','Created');
	define('_AM_TWEETBOMB_FORM_UPDATED_URLS','Updated');	
	
	//Version 1.04
	define('_AM_TWEETBOMB_TH_SURL','Tweet Source URL');
	
	//Version 1.06
	define('_AM_TWEETBOMB_TH_HITS','Hits');
	define('_AM_TWEETBOMB_TH_ACTIVE','Last Linked');
	
	//Version 1.11
	// Table headers
	define('_AM_TWEETBOMB_TH_SID','Schedule ID');
	define('_AM_TWEETBOMB_TH_MODE','Filter Mode');
	define('_AM_TWEETBOMB_TH_PRE','Pre Text');
	define('_AM_TWEETBOMB_TH_TEXT','Tweet Text');
	define('_AM_TWEETBOMB_TH_RANK','Rank');
	define('_AM_TWEETBOMB_TH_TYPE','Campaign Type');
	define('_AM_TWEETBOMB_TH_WHEN','Published');
	define('_AM_TWEETBOMB_TH_TWEETED','Last Retrieved');
	define('_AM_TWEETBOMB_TH_PROVIDER','Provider');
	define('_AM_TWEETBOMB_TH_TWEET','Tweets');
	define('_AM_TWEETBOMB_TH_ALIAS','Alias\'');
	define('_AM_TWEETBOMB_TH_DATE','Date');
	define('_AM_TWEETBOMB_TH_URL','URL');
	
	//Forms Definitions
	define('_AM_TWEETBOMB_FORM_ISNEW_SCHEDULER','New Scheduled Tweet');
	define('_AM_TWEETBOMB_FORM_EDIT_SCHEDULER','Edit Scheduled Tweet');
	define('_AM_TWEETBOMB_FORM_CID_SCHEDULER','Campaign Keyword is For');
	define('_AM_TWEETBOMB_FORM_DESC_CID_SCHEDULER',''); 
	define('_AM_TWEETBOMB_FORM_CATID_SCHEDULER','Category Keyword is For');
	define('_AM_TWEETBOMB_FORM_DESC_CATID_SCHEDULER','');
	define('_AM_TWEETBOMB_FORM_MODE_SCHEDULER','Filter Mode');
	define('_AM_TWEETBOMB_FORM_DESC_MODE_SCHEDULER','');
	define('_AM_TWEETBOMB_FORM_PRE_SCHEDULER','Pre Text in Tweet');
	define('_AM_TWEETBOMB_FORM_DESC_PRE_SCHEDULER','32 Characters');
	define('_AM_TWEETBOMB_FORM_TEXT_SCHEDULER','Suplimental Tweet Text');
	define('_AM_TWEETBOMB_FORM_DESC_TEXT_SCHEDULER','140 Characters');
	define('_AM_TWEETBOMB_FORM_REPLACE_SCHEDULER','String to use in all replacements');
	define('_AM_TWEETBOMB_FORM_DESC_REPLACE_SCHEDULER','Seperate with a | for each replacement in an array.');
	define('_AM_TWEETBOMB_FORM_STRIP_SCHEDULER','Characters to strip from tweet sentence');
	define('_AM_TWEETBOMB_FORM_DESC_STRIP_SCHEDULER','Seperate with a | for each replacement in an array.');
	define('_AM_TWEETBOMB_FORM_SEARCH_SCHEDULER','String to search for in all tweets');
	define('_AM_TWEETBOMB_FORM_DESC_SEARCH_SCHEDULER','Seperate with a | for each replacement in an array.');
	define('_AM_TWEETBOMB_FORM_PREGMATCH_SCHEDULER','Regular Expression to search for with preg_replace');
	define('_AM_TWEETBOMB_FORM_DESC_PREGMATCH_SCHEDULER','Regular Expression');
	define('_AM_TWEETBOMB_FORM_UID_SCHEDULER','Created by');
	define('_AM_TWEETBOMB_FORM_CREATED_SCHEDULER','Created');
	define('_AM_TWEETBOMB_FORM_ACTIONED_SCHEDULER','Actioned');
	define('_AM_TWEETBOMB_FORM_UPDATED_SCHEDULER','Updated');
	define('_AM_TWEETBOMB_FORM_TYPE_CAMPAIGN','Campaign Type');
	define('_AM_TWEETBOMB_FORM_DESC_TYPE_CAMPAIGN','This is the campaign source.');
	define('_AM_TWEETBOMB_FORM_IMPORT_SCHEDULE','Import Text Flat file for Scheduler Tweets');
	define('_AM_TWEETBOMB_FORM_FILE_SCHEDULER','Upload a *.txt or *.log file for tweets.');
	define('_AM_TWEETBOMB_FORM_DESC_FILE_SCHEDULER','');
	
	//Template text
	define('_AM_TWEETBOMB_SCHEDULER_H1','Scheduled Tweets');
	define('_AM_TWEETBOMB_SCHEDULER_P','This is your entered or imported scheduled tweets from here you can edit them and revoke them from the schedule!');
	define('_AM_TWEETBOMB_IMPORT_SCHEDULER_H1','Import Scheduled Tweets');
	define('_AM_TWEETBOMB_IMPORT_SCHEDULER_P','This is where you can upload a log or import a text file of tweets');
	define('_AM_TWEETBOMB_NEW_SCHEDULER_H1','New Scheduled Tweets');
	define('_AM_TWEETBOMB_NEW_SCHEDULER_P','This is where you enter line by line scheduled tweets.');
	define('_AM_TWEETBOMB_LOG_H1','Tweets from Twitter Bomb - Log');
	define('_AM_TWEETBOMB_LOG_P','This is your log of tweets with twitterbomb, they are divided into provider and date and alias of refereer!');
	
	//Version 1.12
	//Forms Definitions	
	define('_AM_TWEETBOMB_FORM_PREGMATCH_REPLACE_SCHEDULER','Pregmatch Replace String');
	define('_AM_TWEETBOMB_FORM_DESC_PREGMATCH_REPLACE_SCHEDULER','Seperate with a pipe (|) to make array, otherwise entry level text replace with regular expression.');

	// Table headers
	define('_AM_TWEETBOMB_TH_SOURCE_NICK','Source Match Nick/Alias');
	define('_AM_TWEETBOMB_TH_TAGS','Tags');
	
?>
	
	