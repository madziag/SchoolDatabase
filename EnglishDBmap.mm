<map version="freeplane 1.8.0">
<!--To view this file, download free mind mapping software Freeplane from http://freeplane.sourceforge.net -->
<node TEXT="SearchRetrieve.php" FOLDED="false" ID="ID_1267102004" CREATED="1617812902468" MODIFIED="1618941559092" STYLE="oval">
<font SIZE="18"/>
<hook NAME="MapStyle" zoom="0.75">
    <properties fit_to_viewport="false" show_icon_for_attributes="true" show_note_icons="true" edgeColorConfiguration="#808080ff,#ff0000ff,#0000ffff,#00ff00ff,#ff00ffff,#00ffffff,#7c0000ff,#00007cff,#007c00ff,#7c007cff,#007c7cff,#7c7c00ff"/>

<map_styles>
<stylenode LOCALIZED_TEXT="styles.root_node" STYLE="oval" UNIFORM_SHAPE="true" VGAP_QUANTITY="24.0 pt">
<font SIZE="24"/>
<stylenode LOCALIZED_TEXT="styles.predefined" POSITION="right" STYLE="bubble">
<stylenode LOCALIZED_TEXT="default" ICON_SIZE="12.0 pt" COLOR="#000000" STYLE="fork">
<font NAME="SansSerif" SIZE="10" BOLD="false" ITALIC="false"/>
</stylenode>
<stylenode LOCALIZED_TEXT="defaultstyle.details"/>
<stylenode LOCALIZED_TEXT="defaultstyle.attributes">
<font SIZE="9"/>
</stylenode>
<stylenode LOCALIZED_TEXT="defaultstyle.note" COLOR="#000000" BACKGROUND_COLOR="#ffffff" TEXT_ALIGN="LEFT"/>
<stylenode LOCALIZED_TEXT="defaultstyle.floating">
<edge STYLE="hide_edge"/>
<cloud COLOR="#f0f0f0" SHAPE="ROUND_RECT"/>
</stylenode>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.user-defined" POSITION="right" STYLE="bubble">
<stylenode LOCALIZED_TEXT="styles.topic" COLOR="#18898b" STYLE="fork">
<font NAME="Liberation Sans" SIZE="10" BOLD="true"/>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.subtopic" COLOR="#cc3300" STYLE="fork">
<font NAME="Liberation Sans" SIZE="10" BOLD="true"/>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.subsubtopic" COLOR="#669900">
<font NAME="Liberation Sans" SIZE="10" BOLD="true"/>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.important">
<icon BUILTIN="yes"/>
</stylenode>
</stylenode>
<stylenode LOCALIZED_TEXT="styles.AutomaticLayout" POSITION="right" STYLE="bubble">
<stylenode LOCALIZED_TEXT="AutomaticLayout.level.root" COLOR="#000000" STYLE="oval" SHAPE_HORIZONTAL_MARGIN="10.0 pt" SHAPE_VERTICAL_MARGIN="10.0 pt">
<font SIZE="18"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,1" COLOR="#0033ff">
<font SIZE="16"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,2" COLOR="#00b439">
<font SIZE="14"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,3" COLOR="#990000">
<font SIZE="12"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,4" COLOR="#111111">
<font SIZE="10"/>
</stylenode>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,5"/>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,6"/>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,7"/>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,8"/>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,9"/>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,10"/>
<stylenode LOCALIZED_TEXT="AutomaticLayout.level,11"/>
</stylenode>
</stylenode>
</map_styles>
</hook>
<hook NAME="AutomaticEdgeColor" COUNTER="30" RULE="ON_BRANCH_CREATION"/>
<richcontent TYPE="NOTE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      Required Variables: NA
    </p>
  </body>
</html>
</richcontent>
<attribute NAME="Required Variables" VALUE="$_POST[&quot;studentID&quot;], $_POST[&quot;firstname&quot;], $_POST[&quot;lastname&quot;], $_POST[&quot;streetaddress&quot;], $_POST[&quot;postcode&quot;], $_POST[&quot;town&quot;], $_POST[&quot;email&quot;], $_POST[&quot;mainphone&quot;], $_POST[&quot;altphone&quot;], $_POST[&quot;status&quot;] "/>
<attribute NAME="Session" VALUE=" $_SESSION[&apos;post-sr&apos;]"/>
<node TEXT="Include: DataInsert.php" POSITION="right" ID="ID_1295258193" CREATED="1617814102874" MODIFIED="1618940962120">
<edge COLOR="#007c00"/>
<attribute NAME="Required Variables" VALUE="$studentID $firstname $lastname $streetaddress $postcode $town $email $mainphone $altphone "/>
<node TEXT="$studentID" ID="ID_1373010345" CREATED="1617814119907" MODIFIED="1618940962118"/>
<node ID="ID_1264457529" CREATED="1617814119908" MODIFIED="1618940962118"><richcontent TYPE="NODE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      $firstname
    </p>
  </body>
</html>
</richcontent>
</node>
<node ID="ID_98646467" CREATED="1617814119909" MODIFIED="1618940962118"><richcontent TYPE="NODE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      $lastname
    </p>
  </body>
</html>
</richcontent>
</node>
<node ID="ID_667652638" CREATED="1617814119911" MODIFIED="1618940962119"><richcontent TYPE="NODE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      $streetaddress
    </p>
  </body>
</html>
</richcontent>
</node>
<node ID="ID_399977022" CREATED="1617814119913" MODIFIED="1618940962119"><richcontent TYPE="NODE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      $postcode
    </p>
  </body>
</html>
</richcontent>
</node>
<node ID="ID_1619000677" CREATED="1617814119915" MODIFIED="1618940962119"><richcontent TYPE="NODE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      $town
    </p>
  </body>
</html>
</richcontent>
</node>
<node ID="ID_561162955" CREATED="1617814119919" MODIFIED="1618940962119"><richcontent TYPE="NODE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      $email
    </p>
  </body>
</html>
</richcontent>
</node>
<node ID="ID_1689841443" CREATED="1617814119921" MODIFIED="1618940962119"><richcontent TYPE="NODE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      $mainphone
    </p>
  </body>
</html>
</richcontent>
</node>
<node ID="ID_1937725737" CREATED="1617814119923" MODIFIED="1618940962120"><richcontent TYPE="NODE">

<html>
  <head>
    
  </head>
  <body>
    <p>
      $altphone
    </p>
  </body>
</html>
</richcontent>
</node>
</node>
<node TEXT="AddNewStudent.php" POSITION="left" ID="ID_126211698" CREATED="1617814457049" MODIFIED="1618942091731">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1295258193" STARTINCLINATION="-265;-109;" ENDINCLINATION="-75;-31;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<edge COLOR="#7c7c00"/>
<attribute NAME="Required Variables" VALUE="$firstname $lastname $streetaddress $postcode $town $email $mainphone $altphone "/>
<attribute NAME="Session" VALUE="$_SESSION[&apos;post-sr&apos;]"/>
<node TEXT="checkBlankInsert.php" ID="ID_486404267" CREATED="1617814930163" MODIFIED="1618940962121">
<arrowlink SHAPE="LINE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_126211698" STARTINCLINATION="166;0;" ENDINCLINATION="166;0;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE="$_POST[&quot;lastname&quot;]"/>
<attribute NAME="Session" VALUE="$_SESSION[&apos;post_insert&apos;]"/>
<node TEXT="ExecuteInsertStudent.php" ID="ID_1752516163" CREATED="1617815293200" MODIFIED="1618942055899">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_126211698" STARTINCLINATION="-62;-164;" ENDINCLINATION="-33;-72;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE="$firstname $lastname $streetaddress $postcode $town $email $mainphone $altphone  $_POST[&apos;status&apos;]"/>
<attribute NAME="Session" VALUE="$_SESSION[&apos;post_insert&apos;]"/>
<node TEXT="CreateContract.php" ID="ID_981567569" CREATED="1617815469497" MODIFIED="1618942085395">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#0000ff" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1267102004" STARTINCLINATION="-297;-1312;" ENDINCLINATION="728;-440;" STARTARROW="DEFAULT" ENDARROW="NONE"/>
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_969245186" STARTINCLINATION="-1502;-1391;" ENDINCLINATION="1427;890;" STARTARROW="DEFAULT" ENDARROW="NONE"/>
<attribute NAME="Required Variables" VALUE="$_GET[&apos;studentID&apos;], "/>
<attribute NAME="Session" VALUE="$_SESSION[&apos;post_insert&apos;]"/>
<node TEXT="CheckBlankContract.php" ID="ID_864936927" CREATED="1617815656345" MODIFIED="1618941769564">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_981567569" STARTINCLINATION="-69;58;" ENDINCLINATION="70;56;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE="$_GET[&apos;studentID&apos;], $_POST[&quot;levelSelect&quot;]"/>
<attribute NAME="Session" VALUE="$_SESSION[&apos;insert-contract&apos;]"/>
<node TEXT="ExecuteInsertContract.php" ID="ID_756128946" CREATED="1617815820714" MODIFIED="1618940962122">
<attribute NAME="Required Variables" VALUE="$_GET[&apos;studentID&apos;], $_POST[&quot;starter&quot;], $_POST[&quot;book&quot;], $_POST[&quot;rate&quot;], $_POST[&apos;month&apos;], $_POST[&apos;year&apos;], $_POST[&apos;day&apos;], $_POST[&apos;locSelect&apos;], $_POST[&apos;ageGroup&apos;], $_POST[&apos;levelSelect&apos;], $_POST[&apos;comments&apos;]"/>
<attribute NAME="Session" VALUE="$_SESSION[&apos;insert-contract&apos;]"/>
<node TEXT="Include: CalculatePayDates.php" ID="ID_1708823094" CREATED="1617815896242" MODIFIED="1618942026908">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1164051912" STARTINCLINATION="-873;-472;" ENDINCLINATION="71;-43;" STARTARROW="DEFAULT" ENDARROW="NONE"/>
<attribute NAME="Required Variables" VALUE="$endschooldate, $startDate, $february"/>
</node>
<node TEXT="Include: CalculateNextPayment.php" ID="ID_1821755665" CREATED="1617815911521" MODIFIED="1618940962122">
<attribute NAME="Required Variables" VALUE="$amountdue $row_contracts $total_amount_paid $contractStatus $row_settings $installmentAmount"/>
<node TEXT="Include: ContractStatus.php" ID="ID_1064905975" CREATED="1617816581081" MODIFIED="1618942019715">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_429730503" STARTINCLINATION="1225;27;" ENDINCLINATION="1034;434;" STARTARROW="DEFAULT" ENDARROW="NONE"/>
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_132652707" STARTINCLINATION="-572;-524;" ENDINCLINATION="-661;-861;" STARTARROW="DEFAULT" ENDARROW="NONE"/>
<attribute NAME="Required Variables" VALUE="$currentMonth, $currentYear, $row_contracts"/>
</node>
<node TEXT="Include: calculateTotalAmountPaid.php" ID="ID_1260562874" CREATED="1617816589482" MODIFIED="1618941710532">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_429730503" STARTINCLINATION="940;103;" ENDINCLINATION="606;189;" STARTARROW="DEFAULT" ENDARROW="NONE"/>
<attribute NAME="Required Variables" VALUE="$row_contracts"/>
</node>
</node>
<node TEXT="DisplayPrintContract.php" ID="ID_1099202086" CREATED="1617815936378" MODIFIED="1618940962123">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1267102004" STARTINCLINATION="30;205;" ENDINCLINATION="-149;325;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE=" $_GET[&apos;studentID&apos;], $_GET[&apos;contractID&apos;]"/>
<node TEXT="UpdateContract.php" ID="ID_573920445" CREATED="1617816160577" MODIFIED="1618940962123">
<attribute NAME="Required Variables" VALUE="$_GET[&apos;studentID&apos;], $_GET[&apos;contractID&apos;]"/>
<node TEXT="ExecuteUpdateContract.php" ID="ID_1841542395" CREATED="1617816250945" MODIFIED="1618941694229">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1099202086" STARTINCLINATION="-152;144;" ENDINCLINATION="27;91;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE="$_GET[&apos;studentID&apos;], $_GET[&apos;contractID&apos;], $_POST[&apos;starter&apos;], $_POST[&apos;book&apos;], $_POST[&apos;group_ind&apos;], $_POST[&apos;group_ind&apos;], $_POST[&apos;contractStartDate&apos;], $_POST[&apos;location&apos;], $_POST[&apos;group&apos;], $_POST[&apos;level&apos;], $_POST[&apos;rate&apos;], $_POST[&apos;nrpayments&apos;], $_POST[&apos;comments&apos;]"/>
</node>
</node>
<node TEXT="DeleteContract.php" ID="ID_771626010" CREATED="1617816181865" MODIFIED="1618941719067">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_981567569" STARTINCLINATION="-64;152;" ENDINCLINATION="-122;104;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE=" $_GET[&apos;studentID&apos;], $_GET[&apos;contractID&apos;]"/>
</node>
</node>
</node>
</node>
</node>
</node>
</node>
</node>
<node TEXT="Dataupdate.php" POSITION="right" ID="ID_969245186" CREATED="1617814566760" MODIFIED="1618941964499">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1267102004" STARTINCLINATION="-51;30;" ENDINCLINATION="7;10;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<edge COLOR="#ff0000"/>
<attribute NAME="Required Variables" VALUE="$_GET[&quot;studentID&quot;]"/>
<node TEXT="ExecuteSignedContract.php" ID="ID_1241184313" CREATED="1618331191421" MODIFIED="1618941798500">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1267102004" STARTINCLINATION="469;-124;" ENDINCLINATION="59;-423;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE="$_GET[&quot;studentID&quot;]"/>
</node>
<node TEXT="ExecuteUpdate.php" ID="ID_1897247550" CREATED="1618331232109" MODIFIED="1618941811795">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1267102004" STARTINCLINATION="249;578;" ENDINCLINATION="19;258;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE="$_GET[&quot;studentID&quot;], $_POST[&apos;status&apos;], $_POST[&apos;update&apos;], $_POST[&apos;firstname&apos;], $_POST[&apos;lastname&apos;], $_POST[&apos;streetaddress&apos;], $_POST[&apos;postcode&apos;], $_POST[&apos;town&apos;], $_POST[&apos;email&apos;], $_POST[&apos;mainphone&apos;], $_POST[&apos;altphone&apos;] "/>
</node>
</node>
<node TEXT="ShowContracts.php" POSITION="right" ID="ID_1655090375" CREATED="1617814633360" MODIFIED="1618941971997">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1267102004" STARTINCLINATION="-30;51;" ENDINCLINATION="27;63;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<edge COLOR="#00ff00"/>
<attribute NAME="Required Variables" VALUE="$_GET[&quot;studentID&quot;]"/>
</node>
<node TEXT="EnterPayment.php" FOLDED="true" POSITION="left" ID="ID_132652707" CREATED="1617814651928" MODIFIED="1618940962117">
<edge COLOR="#ff00ff"/>
<attribute NAME="Required Variables" VALUE="$_GET[&quot;studentID&quot;], "/>
<node TEXT="InsertPayment.php" ID="ID_1164051912" CREATED="1618330065718" MODIFIED="1618941776100">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1267102004" STARTINCLINATION="-41;-4;" ENDINCLINATION="-221;221;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1821755665" STARTINCLINATION="220;300;" ENDINCLINATION="-16;13;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE="$_POST[&quot;todays_date&quot;], $_POST[&quot;contract_id&quot;], $_POST[&quot;PaymentAmount&quot;], "/>
<node TEXT="contracts.php" ID="ID_429730503" CREATED="1618330351791" MODIFIED="1618941785756">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_429730503" STARTINCLINATION="40;0;" ENDINCLINATION="40;45;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_969245186" STARTINCLINATION="640;326;" ENDINCLINATION="481;342;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE="$_GET[&quot;sortByCol&quot;], $_GET[&quot;order&quot;]"/>
</node>
</node>
</node>
<node TEXT="ExecuteInsertSettings.php" POSITION="left" ID="ID_374480941" CREATED="1618333893851" MODIFIED="1618941566676" HGAP_QUANTITY="134.74999640136969 pt" VSHIFT_QUANTITY="234.74999300390505 pt">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1003327921" STARTINCLINATION="500;257;" ENDINCLINATION="256;107;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<edge COLOR="#00ffff"/>
<attribute NAME="Required Variables" VALUE="$_GET[&apos;contract_amount_installments&apos;], $_GET[&apos;contract_amount_infull&apos;"/>
<node TEXT="CheckSettings.php" ID="ID_517461704" CREATED="1618333959828" MODIFIED="1618941569324" HGAP_QUANTITY="52.99999883770947 pt" VSHIFT_QUANTITY="-60.74999818950897 pt">
<arrowlink SHAPE="CUBIC_CURVE" COLOR="#000000" WIDTH="2" TRANSPARENCY="200" FONT_SIZE="9" FONT_FAMILY="SansSerif" DESTINATION="ID_1003327921" STARTINCLINATION="-6;-168;" ENDINCLINATION="-47;-179;" STARTARROW="NONE" ENDARROW="DEFAULT"/>
<attribute NAME="Required Variables" VALUE="$_POST[&apos;contract_amount_installments&apos;], $_POST[&apos;contract_amount_infull&apos;]"/>
<node TEXT="Settings.php" LOCALIZED_STYLE_REF="AutomaticLayout.level.root" ID="ID_1003327921" CREATED="1618333978715" MODIFIED="1618941569324" HGAP_QUANTITY="58.24999868124729 pt" VSHIFT_QUANTITY="-78.74999765306715 pt"/>
</node>
</node>
</node>
</map>
