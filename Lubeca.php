<?php
/**
 * MediaWiki skin for LOOP.
 *
 * @file
 * @ingroup Skins
 * @version 0.1
 * @author Marc Vorreiter
 */

if( !defined( 'MEDIAWIKI' ) ){
	die( "This is a skins file for mediawiki and should not be viewed directly.\n" );
}

global $IP;

require_once ($IP."/extensions/Loop/LoopPiwik.php");

class SkinLubeca extends SkinTemplate {
	var $useHeadElement = true;

	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'lubeca';
		$this->stylename = 'lubeca';
		$this->template  = 'LubecaTemplate';
	}

	function setupSkinUserCss( OutputPage $out ) {
		global $wgDefaultSkin, $wgStylePath,$wgLoopCustomCss, $wgResourceModules,$wgLubecaSkinCss, $wgText2Speech; 
		parent::setupSkinUserCss( $out );

		$out->addStyle( 'lubeca/css/main.css', 'screen' );

		if ($wgLoopCustomCss!='') {
			$out->addStyle( 'lubeca/css/'.$wgLoopCustomCss, 'screen' );
		}
		if ($wgLubecaSkinCss!='') {
			$out->addStyle( 'lubeca/css/'.$wgLubecaSkinCss, 'screen' );
		}


		$out->addJsConfigVars('wgDefaultSkin',$wgDefaultSkin);
		$out->addJsConfigVars('wgStylePath',$wgStylePath );

		$out->addHeadItem( 'viewport', '<meta id="viewport" name="viewport" content="width=1380" />' );


		
		#$out->addHeadItem( 'jquerycookiejs', '<script type="text/javascript" src="/mediawiki/resources/jquery/jquery.cookie.js"></script>' );
		$out->addHeadItem( 'lubecajs', '<script type="text/javascript" src="'.$wgStylePath.'/lubeca/js/lubeca.js"></script>' );
		$out->addHeadItem( 'modernizr', '<script type="text/javascript" src="'.$wgStylePath.'/lubeca/js/modernizr.custom.js"></script>' );

    if ($wgText2Speech==true) {
      $out->addHeadItem( 't2s', '<script type="text/javascript" src="/mediawiki/extensions/LoopMediaHandler/js/jquery.jplayer.min.js"></script>' );
      $out->addHeadItem( 't2scss', '<link type="text/css" href="/mediawiki/extensions/LoopMediaHandler/skins/jplayer.t2s.css" rel="stylesheet" />' );
      #$out->addHeadItem( 'jqueryjs', '<script type="text/javascript" src="/mediawiki/resources/jquery/jquery.js"></script>' );
      $out->addHeadItem( 'jplayerdefault', '<link type="text/css" href="/mediawiki/extensions/LoopMediaHandler/skins/jplayer.blue.monday.css" rel="stylesheet" />' );
      
         
    }

	}

	function addToBodyAttributes( $out, &$bodyAttrs ) {
		$bodyAttrs['onload'] = 'init_sidebars();';
	}


	function doEditSectionLink( Title $nt, $section, $tooltip = null, $lang = false ) {
		$attribs = array();
		if ( !is_null( $tooltip ) ) {
			# Bug 25462: undo double-escaping.
			$tooltip = Sanitizer::decodeCharReferences( $tooltip );
			$attribs['title'] = wfMsgExt( 'editsectionhint', array( 'language' => $lang, 'parsemag' ), $tooltip );
		}
		$linktext='<div class="editicon"></div>';

		$link = Linker::link( $nt, $linktext,
		$attribs,
		array( 'action' => 'edit', 'section' => $section ),
		array( 'noclasses', 'known' )
		);
		$result = "<span class=\"editsection\">$link</span>";

		return $result;
	}

}




class LubecaTemplate extends BaseTemplate {

	public function execute() {
		global $wgRequest, $wgText2Speech, $wgPiwikTracking, $IP, $wgPiwikUrl,$wgPiwikTokenAuth;

    require_once ($IP."/extensions/Loop/LoopPiwik.php");

		$skin = $this->data['skin'];
		wfSuppressWarnings();


		$this->html( 'headelement' );
		?>
		
<script type="text/javascript">
function getStyleObject(objectId) {
	// checkW3C DOM, then MSIE 4, then NN 4.
	//
	if(document.getElementById) {
	if (document.getElementById(objectId)) {
	return document.getElementById(objectId).style;
	}
	} else if (document.all) {
	if (document.all(objectId)) {
	return document.all(objectId).style;
	}
	} else if (document.layers) {
	if (document.layers[objectId]) {
	return document.layers[objectId];
	}
	} else {
	return false;
	}
	}
function toggleObjectVisibility(objectId) {
	// first get the object's stylesheet
	var styleObject = getStyleObject(objectId);
	// then if we find a stylesheet, set its visibility
	// as requested
	//
	if (styleObject) {
	if (styleObject.display == 'none') {
	styleObject.display = 'block';
	} else {
	styleObject.display = 'none';
	}
	return true;
	} else {
	return false;
	}
	}
</script>

<div id="outerwrapper">
<div id="wrapper">
<div id="header">
<div id="headerNav"><?php $this->getHeaderNav()?></div>
</div>
<div id="navbar1">
<div id="navbar1_left">&nbsp;</div>
<div id="navbar1_middle">
<div id="headerMenu"><?php $this->getMenuLeft();?></div>
<div id="headerNavi"><?php $this->getNavigation();?></div>
</div>
<div id="navbar1_right">&nbsp;</div>
</div>
<div class="clearer"></div>
<div id="navbar2">
<div id="navbar2_left">&nbsp;</div>
<div id="navbar2_middle"><?php $this->getBreadcrumbs();?></div>
<div id="navbar2_right">&nbsp;</div>
</div>
<div class="clearer"></div>
<div id="content">
<div id="sidebar_left"><?php $this->getSidebarLeft( $this->data['sidebar']);?>
<!-- 
				<div class="box">
					<div class="box_header">Inhaltsverzeichnis</div>
					<div class="box_body">left<br/>left<br/>left<br/></div>
				</div>
				<div class="box">
					<div class="box_header">Seitenthemen</div>
					<div class="box_body">left<br/>left<br/>left<br/>
					</div>
				</div>
				 --></div>
<div id="content_main">
<div id="content_bar">
<div id="toggle_sidebar_left" href="#" onClick="toggle_left();"
	class="toggle_sidebar_left_open"></div>
<div id="toggle_sidebar_right" href="#" onClick="toggle_right();"
	class="toggle_sidebar_right_open"></div>

		<?php $this->getSearchfield();?>
			<?php
	
if ($wgText2Speech==true) {
	$this->getPageAudioplayer();
}

?>
		
		</div>

<div id="content_body" class="audio"><?php
$this->getPageTitle();
$this->html('bodytext');
?></div>
</div>
<div id="sidebar_right"><?php $this->getSidebarRight( $this->data['sidebar']);?>
<!-- 
				<div class="box">
					<div class="box_header">RIGHT</div>
					<div class="box_body">right<br/>right<br/>right<br/>right<br/>right<br/>right<br/></div>
				</div>
				 --></div>
</div>
<div class="clearer"></div>
<div id="content_footer">
<div id="content_footer_left">&nbsp;</div>
<div id="content_footer_middle">
<div id="content_footer_seperator"></div>
<div id="content_sub"><?php 
//$this->html('subtitle');
$this->getPageInfo();
?></div>
<div id="footerNavi"><?php $this->getNavigation();?></div>
</div>
<div id="content_footer_right">&nbsp;</div>
</div>
<div class="clearer"></div>
<div id="footer">
<div id="footer_left">&nbsp;</div>
<div id="footer_middle">
<div>
<div id="footer_middle_left"><?php $this->getFooterMiddleLeft();?></div>
<div id="footer_middle_middle"><?php $this->getFooterMiddleMiddle();?></div>
<div id="footer_middle_right"><?php $this->getFooterMiddleRight();?></div>
<div style="clear: right;"></div>
</div>
</div>
<div id="footer_right">&nbsp;
<?php
if ($wgPiwikTracking) {
	$loopurl = $_SERVER["SERVER_NAME"];
	$looppiwik = new Piwik($wgPiwikUrl,$wgPiwikTokenAuth);
	$loop_piwik_id= $looppiwik->getSiteId($loopurl);
	if (!$loop_piwik_id) {
		$loop_piwik_id = $looppiwik->addSite($loopurl);
	}
	$loop_piwik_trackingcode=$looppiwik->getTrackingCode($loop_piwik_id);
	echo $loop_piwik_trackingcode;
}
?></div>
</div>
<div class="clearer"></div>
</div>
</div>

<?php
$this->html('bottomscripts');
?>
</body>
</html>
<?php
wfRestoreWarnings();
	} // end of execute() method

	
		/* -------------------------------------------------------------------------------------------------- */
	
	
function getPageAudioplayer() {
		global $wgScriptPath, $wgDefaultSkin, $wgUser, $wgServer, $wgOut, $wgParser;
		
			wfDebug( __METHOD__ . ': wgParser : '.print_r($wgParser,true));
	
		
		$media_id=uniqid();
		$return='';
		
		$return.='<div id="pageaudio_container">
<div id="pageaudio_playbutton">
	<div class="jp-interface">
		<ul class="jp-controls">
			<li><a href="javascript:;" class="jp-playpage" tabindex="1">play page</a></li>
		</ul>
	</div>
</div>

<div id="pageaudio">
  <div id="jquery_jplayer_pageaudio" class="jp-jplayer"></div>
  <div id="jp_container_pageaudio" class="jp-audio">
    <div class="jp-type-single">
      <div class="jp-gui jp-interface">
        <ul class="jp-controls">
          <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
          <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
          <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
          <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
          <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
          <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>          
        </ul>
        <div class="jp-progress">
          <div class="jp-seek-bar">
            <div class="jp-play-bar"></div>
          </div>
        </div>
        <div class="jp-volume-bar">
          <div class="jp-volume-bar-value"></div>
        </div>
        <div class="jp-time-holder">
          <div class="jp-current-time"></div>
          <div class="jp-duration"></div>
        </div>
      </div>
      <div class="jp-no-solution">
        <span>'.wfMsg('cantplay_solution_flash').'</span>        
      </div>
    </div>
  </div>
</div>  
<div id="pageaudio_loader"></div>  
</div>';
		
$script='  <script type="text/javascript">
    $(document).ready(function(){
      $("#pageaudio").css("display","none");
        
      $("#jquery_jplayer_pageaudio").jPlayer({

        swfPath: "/mediawiki/extensions/LoopMediaHandler/js",
        supplied: "mp3",
        cssSelectorAncestor: "#jp_container_pageaudio"
      });

      $("#pageaudio_playbutton").click(function(){

    	  
    	  $.ajax({
				url: "http://'.$_SERVER['SERVER_NAME'].'/mediawiki/LoopPageaudio.php",
				data: "play='.$_SERVER['SCRIPT_URI'].'",
				cache: false,
				dataType: "html"
			}).done(function(data) {
				
				var audiofile = data.toString();

				$("#jquery_jplayer_pageaudio").jPlayer("setMedia", {mp3:audiofile});
								
				 $("#pageaudio_loader").css("display","none");

				 $("#jquery_jplayer_pageaudio").jPlayer("play");
			}).fail(function(xhr, textStatus, errorThrown) { 
				alert(textStatus + " : " + xhr.responseText);
			});
    	  $("#pageaudio_playbutton").css("display","none");
    	  $("#pageaudio_loader").css("display","block");
		  $("#pageaudio").css("display","block");
          
    	
	  });          
    });
  </script>';				

$return.=$script;
echo $return;
}

	/* -------------------------------------------------------------------------------------------------- */

	function getSearchfield() {

		global $IP, $wgServer, $wgStylePath;
		/*
		 echo '<form action="';
		 echo $this->text('wgScript');
		 echo '" id="searchform">';
		 echo '<input type="hidden" name="title"	value="';
		 echo $this->text( 'searchtitle' );
		 echo '" />';
		 echo '<input id="searchInput" accesskey="f" title="DevLoop durchsuchen [alt-shift-f]" value="Modul durchsuchen" name="search" onfocus="focus_search();" onblur="blur_search();" >';
		 echo '<div id="searchButton" onclick="submit_search();"></div>';
		 echo '</form>';
		 */
		?>
<div id="p-search">
<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
<div><?php echo $this->makeSearchInput( array( 'id' => 'searchInput', 'value'=>'Modul durchsuchen' ) ); ?>

		<?php
		// echo $this->makeSearchButton( 'fulltext', array( 'id' => 'mw-searchButton', 'class' => 'searchButton' ) );
		echo $this->makeSearchButton( 'image', array( 'src'=>$wgStylePath.'/lubeca/pix/spacer.png', 'id' => 'mw-searchButton', 'class' => 'searchButton' ) );
		?> <input type='hidden' name="title"
	value="<?php $this->text( 'searchtitle' ) ?>" /></div>
</form>
</div>
		<?php

	}

/* -------------------------------------------------------------------------------------------------- */	
	function getPageInfo() {
		$content='';
		foreach( $this->getFooterLinks() as $key => $value ) {
			if ($key=='info') {
				$content.= '<ul id="footer-'.$key.'">';
				foreach( $value as $v ) {
					if (($v=='lastmod')||($v=='viewcount')||($v=='copyright')) {
						$content.= '<li id="footer-'.$key.'-'.$v.'">';
						$content.= $this->data[$v];
						$content.= '</li>';
					}
				}
				$content.= '</ul>';
			}
		}	
	echo $content;
}
	
	/* -------------------------------------------------------------------------------------------------- */

	function getHeaderNav() {
		$first=true;
		echo "<ul>";
		foreach($this->getPersonalTools() as $key => $item) {
			
			if (($key != 'mytalk')&&($key != 'watchlist')&&($key != 'newmessages')) { // newmessages
				if ($first) {
					$first=false;
				} else {
					echo '<li>|</li>';
				}
				echo $this->makeListItem($key, $item);
			}
		}
		echo "</ul>";
	}

	/* -------------------------------------------------------------------------------------------------- */

	function getNavigation() {
		global $wgServer, $wgScriptPath, $wgStylePath, $wgParser;
		$article_id=($GLOBALS["wgTitle"]->mArticleID);
		if ($article_id) {
			$item = LoopStructureItem::newFromArticleId($article_id);
			if ($item){
				echo wfLoopStructureNavigation($item);
			} else {

				/*
				 $return.='<a href="'.$wgServer.'/'.$wgScriptPath.'/" alt="Home" title="Home"><img src="'.$wgStylePath .'/loop/images/navigation/topnavbutt_main.png" class="navpoint"></a> ';
				 $return.='<img src="'.$wgStylePath .'/loop/images/navigation/topnavbutt_home_in.png" class="navpoint"> ';
				 $return.='<img src="'.$wgStylePath .'/loop/images/navigation/topnavbutt_previouscap_in.png" class="navpoint"> ';
				 $return.='<img src="'.$wgStylePath .'/loop/images/navigation/topnavbutt_back_in.png" class="navpoint"> ';
				 $return.='<img src="'.$wgStylePath .'/loop/images/navigation/topnavbutt_directory_in.png" class="navpoint"> ';
				 */
				$return.='<a href="'.$wgServer.'/'.$wgScriptPath.'/" alt="Home" title="Home"><div class="navicon_main"></div></a>';
				$return.='<div class="navicon_home_in"></div>';
				$return.='<div class="navicon_previouscap_in"></div>';
				$return.='<div class="navicon_back_in"></div>';
				$return.='<div class="navicon_directory_in"></div>';


				$tempTitle=Title::newMainPage();
				if ($GLOBALS["wgTitle"]->mUrlform==$tempTitle->mUrlform)
				{ // Startseite
					$dbr = wfGetDB( DB_SLAVE );
					$res = $dbr->select(
			'loopstructure',
					array(
                'Id',
                'IndexArticleId',
                'TocLevel',
                'TocNumber',
                'TocText',
                'Sequence',
                'ArticleId',
                'PreviousArticleId',
                'NextArticleId',
                'ParentArticleId'
                ),
                array(
				'Sequence' => 0,
				'IndexOrder' => 1
                ),
                __METHOD__,
                array()
                );
                if ($res->result) {
                	$row = $dbr->fetchRow( $res );

                	//var_dump($row);
                	$tArticleId=$row["ArticleId"];
                	if ($$tArticleId)	{
                		$tempArticle= Article::newFromID($tArticleId);
                		if ($tempArticle) {
                			$tempTitle=($tempArticle->getTitle());
                			if ($tempTitle) {
                				$return.= '<a href="'.$tempTitle->getFullURL().'" alt="'.$tempTitle->mTextform.'" title="'.$tempTitle->mTextform.'"><div class="navicon_next"></div></a>';
                			} else {
                				$return.='<div class="navicon_next_in"></div>';
                			}
                		} else {
                			$return.='<div class="navicon_next_in"></div>';
                		}
                		 
                	} else {
                		$return.='<div class="navicon_next_in"></div>';
                	}

                } else {
                	$return.='<div class="navicon_next_in"></div>';
                }
                 
                 
                 
                 
				} else {
					$return.='<div class="navicon_next_in"></div>';
				}

				$return.='<div class="navicon_nextcap_in"></div>';
				//echo "&nbsp;";
				echo $return;
			}
		} else {
			echo "&nbsp;";
		}
	}

	/* -------------------------------------------------------------------------------------------------- */

	function getBreadcrumbs() {
		global $wgLoopStructureBreadcrumbLength, $wgLoopStructureUseMainpageForBreadcrumb;
		if (!$wgLoopStructureBreadcrumbLength) {
			$wgLoopStructureBreadcrumbLength=100;
		}
		if ($wgLoopStructureUseMainpageForBreadcrumb==true) {
			$tempTitle=Title::newMainPage();
			echo '<a href="'.$tempTitle->getFullURL().'" alt="'.$tempTitle->mTextform.'" title="'.$tempTitle->mTextform.'">'.$tempTitle->mTextform.'</a> ';
		}
		$article_id=($GLOBALS["wgTitle"]->mArticleID);
		if ($article_id!=0) {
			$item = LoopStructureItem::newFromArticleId($article_id);
			if (!empty($item)) {
				if ($wgLoopStructureUseMainpageForBreadcrumb==true) {echo '&raquo; ';}
				echo wfLoopStructureBreadcrumb($item,$wgLoopStructureBreadcrumbLength);
			}
		} else {
			echo "&nbsp;";
		}
	}

	/* -------------------------------------------------------------------------------------------------- */

	function getMenuLeft() {
		echo "<ul>";
		foreach ($this->data['sidebar']['MENULEFT'] as $menuitem) {
			echo '<li class="page_item"><a href="'.$menuitem['href'].'">'.$menuitem['text'].'</a></li>';
		}
		echo "</ul>";
	}

	/* -------------------------------------------------------------------------------------------------- */
	function getFooterMiddleLeft() {
		// Content Actions
		echo "<ul>";
		foreach($this->data['content_actions'] as $key => $tab) {
			
			// echo "<!-- ".$key." -->";
			if (($key != 'nstab-main')&&($key != 'view')&&($key != 'talk')&&($key != 'current')&&($key != 'watch')&&($key != 'unwatch')) {
				$linkAttribs = array( 'href' => $tab['href'] );
				if( isset( $tab["tooltiponly"] ) && $tab["tooltiponly"] ) {
					$title = Linker::titleAttrib( "ca-$key" );
					if ( $title !== false ) {
						$linkAttribs['title'] = $title;
					}
				} else {
					$linkAttribs += Linker::tooltipAndAccesskeyAttribs( "ca-$key" );
				}
				$linkHtml = Html::element( 'a', $linkAttribs, $tab['text'] );
				$liAttribs = array( 'id' => Sanitizer::escapeId( "ca-$key" ) );
				if( $tab['class'] ) {
					$liAttribs['class'] = $tab['class'];
				}
			echo Html::rawElement( 'li', $liAttribs, $linkHtml );
			}
		}
		echo "</ul>";
	}

	/* -------------------------------------------------------------------------------------------------- */
 
	function getFooterMiddleMiddle() {
		global $wgLoopShowUnprotectedRSSLink;

		// Toolbox
		echo "<ul>";
		foreach ( $this->getToolbox() as $key => $tbitem ) {
			//echo "<!-- KEY:".$key." ITEM:".$tbitem." -->";
			if (($key!='print')&&($key!='whatlinkshere')&&($key!='recentchangeslinked')&&($key!='permalink')) {
				echo $this->makeListItem($key, $tbitem);
			}
		}
		wfRunHooks( 'LoopTemplateToolboxEnd', array( &$this ) );
		wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ) );

		if ($wgLoopShowUnprotectedRSSLink==true) {
			echo '<li>';
			echo '<a class="loop_rss" href="/mediawiki/recentchanges.php">'.wfMsg('loopRecantChangesAll').'</a>';
			echo '</li>';
		}

		echo "</ul>";
	}


	/* -------------------------------------------------------------------------------------------------- */

	function getFooterMiddleRight() {
	global $wgManualImprint;
	
		foreach( $this->getFooterLinks() as $key => $value ) {
			if ($key=='places') {
				echo '<ul id="footer-'.$key.'">';
				
				
				echo '<li id="footer-places-disclaimer">';
				if ($wgManualImprint == true) {
          echo '<a href="'.$wgServer.'/loop/'.wfMsg('loopimprint').'">'.wfMsg('loopimprint').'</a>';
				} else {
          echo '<a href="'.$wgServer.'/loop/Special:LoopImprint">'.wfMsg('loopimprint').'</a>';
				}
				echo '</li>';
				
				echo '<li>';
				echo '<a href="http://loop.oncampus.de/loop/LOOP" target="_blank">'.wfMsg('loopaboutloop').'</a>';
				echo '</li>';
				
				echo '<li>';
				echo '<a href="http://loop.oncampus.de/loop/Hilfe" target="_blank">'.wfMsg('loophelp').'</a>';
				echo '</li>';
				
				echo '<li>';
				echo '<a href="http://www.oncampus.de" target="_blank">oncampus</a>';
				echo '</li>';				
				
				/*
				foreach( $value as $v ) {
					if ($v=='disclaimer') {
						echo '<li id="footer-'.$key.'-'.$v.'">';
						echo '<a href="'.$wgServer.'/loop/Spezial:LoopImprint">'.wfMsg('loopimprint').'</a>';
						echo '</li>';
					} else {
						echo '<li id="footer-'.$key.'-'.$v.'">';
						echo $this->html($v);
						echo '</li>';
					}
				}
				*/
				echo '</ul>';
			}
		}
	}

	/* -------------------------------------------------------------------------------------------------- */

	function getSidebarLeft($sidebar) {

		foreach( $sidebar as $boxName => $content ) {
			if ( $content === false )
			continue;

			if ( $boxName == 'LOOPTOC' ) {
				$this->blockLooptoc();
			}  elseif ($boxName!='MENULEFT' && $boxName!='MENURIGHT' && $boxName!='TOOLBOX'  && $boxName!='PAGETOC' && $boxName!='PAGEINFO' && $boxName!='FACEBOOK') {
				$this->customBox( $boxName, $content );
			}
		}
		
		echo '<div class="generated-sidebar portlet" id="p-Ausgabeformate"><h2>'.wfMsg('loopausgabeformate').'</h2><div class="pBody"><ul><li id="n-PDF"><a href="/loop/Special:LoopPrintversion">PDF</a></li><li id="n-ePub"><a href="/loop/Special:EPubPrint">ePub</a></li></ul></div></div>';
	}

	/* -------------------------------------------------------------------------------------------------- */

	function getSidebarRight($sidebar) {
	global $wgShowRevisionBlock;

		// var_dump($sidebar);

		$this->blockPageDiscussion();
		if ($wgShowRevisionBlock==true) {
      $this->blockPageInfo();
		}
		foreach( $sidebar as $boxName => $content ) {
			if ( $content === false )
			continue;

			if ( $boxName == 'PAGETOC' ) {
				$this->blockPagetoc();
			}
			
			if ( $boxName == 'PAGEINFO' ) {
				// $this->blockPageInfo();
			}
			
			if ( $boxName == 'FACEBOOK' ) {
				$this->blockFacebook($content);
			}

		}
		
		
		
	}

	/* -------------------------------------------------------------------------------------------------- */
	
	
function blockPageDiscussion($content) {
    global $wgUser;
    $return='';
    $show=true;
		if ($this->data['content_actions']['talk']) {
			$return.='<div id="sidebarDiscussion" class="generated-sidebar portlet">';
			$return.='<h2>'.wfMsg('loopPageDiscussion').'</h2><div class="pBody">';
			if ($this->data['content_actions']['talk']['class']=='new') {
        if ($wgUser->isAllowed('createtalk')) {
            $return.='<a class="talklink_new" alt="discussion" title="'.wfMsg('loopPageDiscussion').'" href="'.$this->data['content_actions']['talk']['href'].'">'.wfMsg('loopTalkStart').'</a>';
         } else {
         $show=false;
         }
			} else {
       
				$return.='<a class="talklink" alt="discussion" title="'.wfMsg('loopPageDiscussion').'" href="'.$this->data['content_actions']['talk']['href'].'">'.wfMsg('loopTalk').'</a>';
			}
			$return.="</div></div>";
		}				
    if ($show==true) {
      echo $return;
    }
	}

	/* -------------------------------------------------------------------------------------------------- */
		
	function blockFacebook($content) {

			
		$params=array();
		$params['href']='http://www.facebook.com/pages/Oncampus/143159455713611';
		$params['width']='227';
		$params['height']='63';
		$params['colorsheme']='light';
		$params['show_faces']='false';
		$params['stream']='false';
		$params['header']='false';
		$params['border_color']='#ffffff';
		$params['force_wall']='false';
		$params['title']='Facebook';
			
			
		foreach ($content as $part) {
			$param=strtolower(substr($part['href'],6));
			$value=$part['text'];
			$params[$param] = $value;
		}
			
		$url='http://www.facebook.com/plugins/likebox.php';
		$first=true;
		foreach ($params as $param => $value ) {
			if ($param!=title) {
				if($first) {
					$url.='?';
					$first=false;
				} else {
					$url.='&';
				}
				$url.=$param.'='.$value;
			}
		}
			
		$url=htmlentities($url);
		$url=str_replace('#', '%23', $url);
		echo '<div id="sidebarFacebook" class="generated-sidebar">';
		echo '<h2>'.$params['title'].'</h2>';
		echo '<div class="pBody"><iframe id="facebooksidebar" src="'.$url.'" scrolling="no" frameborder="0" allowTransparency="true" style="height:'.$params['height'].'px;"></iframe></div>';
		echo "</div>";

	}

	/* -------------------------------------------------------------------------------------------------- */

	function blockPageInfo() {

		$content='';
		foreach( $this->getFooterLinks() as $key => $value ) {
			if ($key=='info') {
				//$content.= '<ul id="footer-'.$key.'">';
				//$content.= '<li>';
				$content.= $this->data['subtitle'];
				//$content.= '</li>';
				/*
				foreach( $value as $v ) {
					if (($v=='lastmod')||($v=='viewcount')) {
						$content.= '<li id="footer-'.$key.'-'.$v.'">';
						$content.= $this->data[$v];
						$content.= '</li>';
					}
				}
				*/
				//$content.= '</ul>';
			}
		}

		if ($content!='') {
			echo '<div id="sidebarPageInfo" class="generated-sidebar">';
			echo '<h2>'.wfMsg('looppageinfo').'</h2><div class="pBody">';
			echo $content;
			echo "</div></div>";

		}
	}



	/* -------------------------------------------------------------------------------------------------- */


	function getPageTitle() {
		global $wgParserConf, $wgLoopShowPagetitle, $wgLoopStructureNumbering;	

    if ($this->data['nsnumber']==0) {

		$tocnumber='';
		$toctext='';
  		$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
			'loopstructure',
			array(
                'TocNumber',
                'TocText',
				'TocLevel'
                ),
                array(
				'ArticleId' => $this->data['articleid']
                ),
                __METHOD__,
                array(
				'ORDER BY' => 'Sequence ASC'
				)
				);		
		foreach ( $res as $row ) {
			$tocnumber=$row->TocNumber;
			$toctext=$row->TocText;
			$toclevel=$row->TocLevel;
		}		
		
		if ($wgLoopShowPagetitle) {
			$pagetext=$this->data['bodytext'];
			$pattern = "/(\r\n|\r|\n)/";
			$replacement = PHP_EOL;
			$string = preg_replace($pattern, $replacement, $pagetext);
			$matches=array();
			preg_match_all("|<h[^>]+>(.*)</h[^>]+>|U",$string,$matches, PREG_PATTERN_ORDER);
	
			$topics=array();
			foreach ($matches[0] as $match) {
				$istocline=false;
				$indent=substr ($match, 2,1);
				$matches2=array();
				preg_match_all('|((<span class="mw-headline" id=")(.*)(">))(.*)((</span>))|U',$match,$matches2, PREG_PATTERN_ORDER);
				if(($matches2[3][0])&&($matches2[5][0])) {
					$temptoctitle_link=$matches2[3][0];
					$temptoctitle=$matches2[5][0];
					$istocline=true;
				}
				if ($istocline) {
					$topics[]= $temptoctitle;
				}
			}			
			
			if ($toclevel <= 1) {
				$hlevel = '1';	
			} elseif ($toclevel == 2) {
				$hlevel = '2';	
			} elseif ($toclevel > 2) {				
				$hlevel = '3';	
			}
			$firsttitle=array_shift($topics);
			if (trim($firsttitle)!=trim($this->data['title'])) {
				// echo '<h1>'.$firsttitle.'</h1>';
				if ($toctext!='') {
					if ($wgLoopStructureNumbering==true) {
						echo '<h'.$hlevel.'>'.$tocnumber.' '.$toctext.'</h'.$hlevel.'>';
					} else {
						echo '<h'.$hlevel.'>'.$toctext.'</h'.$hlevel.'>';
					}	
				} else {
					echo '<h'.$hlevel.'>'.$this->data['title'].'</h'.$hlevel.'>';
				}
			}
		}
		}
	}

	/* -------------------------------------------------------------------------------------------------- */


	function blockLooptoc() {
		$structure=new LoopStructure();
		$renderedStructure=$structure->renderLoopTocComplete();
		if ($renderedStructure!=''){
			echo $renderedStructure;
		}
	}

	/* -------------------------------------------------------------------------------------------------- */


	function customBox( $bar, $cont ) {
		$portletAttribs = array( 'class' => 'generated-sidebar portlet', 'id' => Sanitizer::escapeId( "p-$bar" ) );
		$tooltip = Linker::titleAttrib( "p-$bar" );
		if ( $tooltip !== false ) {
			$portletAttribs['title'] = $tooltip;
		}
		echo '	' . Html::openElement( 'div', $portletAttribs );
		echo '<h2>';
		$msg = wfMessage( $bar );
		if ($msg->exists()) {
			echo htmlspecialchars($msg->text());
		} else {
			echo htmlspecialchars($bar);
		}
		echo '</h2>';
		echo '<div class="pBody">';
		if ( is_array( $cont ) ) {
			echo '<ul>';
			foreach($cont as $key => $val) {
				echo $this->makeListItem($key, $val);
			}
			echo '</ul>';
		} else {
			print $cont;
		}
		echo '</div></div>';

	}


	/* -------------------------------------------------------------------------------------------------- */


	function blockPagetoc() {
		global $wgParserConf;

		$pagetext=$this->data['bodytext'];
		$pattern = "/(\r\n|\r|\n)/";
		$replacement = PHP_EOL;
		$string = preg_replace($pattern, $replacement, $pagetext);
		$matches=array();
		preg_match_all("|<h[^>]+>(.*)</h[^>]+>|U",$string,$matches, PREG_PATTERN_ORDER);
		//var_dump($matches[0]);

		$topics=array();
		foreach ($matches[0] as $match) {
			$istocline=false;
			//echo $match.'<br/>';
			$indent=substr ($match, 2,1);
			//var_dump($indent);

			$matches2=array();
			preg_match_all('|((<span class="mw-headline" id=")(.*)(">))(.*)((</span>))|U',$match,$matches2, PREG_PATTERN_ORDER);
			//var_dump($matches2);

			if(($matches2[3][0])&&($matches2[5][0])) {
				//var_dump($matches2[2][0]);
				$temptoctitle_link=$matches2[3][0];
				$temptoctitle=$matches2[5][0];

				$istocline=true;
			}

			if ($istocline) {
				$topics[]= '<li class="pagetoclevel-'.$indent.'"><a href="#'.$temptoctitle_link.'">'.$temptoctitle.'</a></li>';
			}
		}

		if (count($topics)>2) {
			echo '<div id="sidebarPageToc" class="generated-sidebar">';
			echo '<h2>'.wfMsg('loopPageToc').'</h2><div class="pBody">';
			echo '<ul>';
			foreach ($topics as $topic) {
				echo $topic;
			}
			echo '</ul>';
			echo '</div></div>';
		}

	}




} // end of class




?>