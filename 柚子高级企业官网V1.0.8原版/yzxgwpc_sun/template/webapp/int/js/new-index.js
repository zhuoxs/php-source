
锘�/**
 * jquery-s2t v0.1.0
 *
 * https://github.com/hustlzp/jquery-s2t
 * A jQuery plugin to convert between Simplified Chinese and Traditional Chinese.
 * Tested in IE6+, Chrome, Firefox.
 *
 * Copyright 2013-2014 hustlzp
 * Released under the MIT license
 */

(function($) {

    // 鍏辨敹褰�2553鏉＄畝绻佸鐓�
    // 灏氭湭鑰冭瘉鏄惁姝ｇ‘銆侀噸澶嶃€佸畬鏁�

    /**
     * 绠€浣撳瓧
     * @const
     */
    var S = new String('涓囦笌涓戜笓涓氫笡涓滀笣涓袱涓ヤ抚涓脯涓颁复涓轰附涓句箞涔変箤涔愪箶涔犱埂涔︿拱涔变簤浜庝簭浜戜簶浜氫骇浜╀翰浜典焊浜夸粎浠庝粦浠撲华浠环浼椾紭浼欎細浼涗紴浼熶紶浼や讥浼︿姬浼极浣撲綑浣ｄ渐渚犱荆渚ヤ睛渚т鲸渚╀惊渚浚淇︿卡淇╀开淇€哄€惧伂鍋诲伨鍋垮偉鍌у偍鍌╁効鍏戝厲鍏氬叞鍏冲叴鍏瑰吇鍏藉唩鍐呭唸鍐屽啓鍐涘啘鍐㈠啹鍐插喅鍐靛喕鍑€鍑勫噳鍑屽噺鍑戝嚊鍑犲嚖鍑嚟鍑嚮鍑煎嚳鍒嶅垝鍒樺垯鍒氬垱鍒犲埆鍒埈鍒藉埧鍓€鍓傚墣鍓戝墺鍓у姖鍔炲姟鍔㈠姩鍔卞姴鍔冲娍鍕嬪嫄鍕氬寑鍖﹀尞鍖哄尰鍗庡崗鍗曞崠鍗㈠崵鍗у崼鍗村嵑鍘傚巺鍘嗗帀鍘嬪帉鍘嶅帟鍘㈠帲鍘﹀帹鍘╁幃鍘垮弬鍙嗗弴鍙屽彂鍙樺彊鍙犲彾鍙峰徆鍙藉悂鍚庡悡鍚曞悧鍚ｅ惃鍚惎鍚村憭鍛撳憰鍛栧憲鍛樺憴鍛涘憸鍜忓挃鍜欏挍鍜濆挙鍜村捀鍝屽搷鍝戝搾鍝撳摂鍝曞摋鍝欏摐鍝濆摕鍞涘敐鍞犲敗鍞㈠敚鍞ゅ斂鍟у暚鍟暜鍟板暣鍟稿柗鍠藉柧鍡懙鍡冲槝鍢ゅ槺鍣滃櫦鍤ｅ毌鍥㈠洯鍥卞洿鍥靛浗鍥惧渾鍦ｅ湽鍦哄潅鍧忓潡鍧氬潧鍧滃潩鍧炲潫鍧犲瀯鍨呭瀱鍨掑灕鍨у灘鍨灜鍨灡鍨插灤鍩樺煓鍩氬煗鍩爲鍫曞澧欏．澹板３澹跺８澶勫澶嶅澶村じ澶瑰ず濂佸濂嬪濂ュ濡囧濡╁Κ濡濮滃▌濞呭▎濞囧▓濞卞ú濞村┏濠村┑濠跺瀚掑珨瀚卞瀛欏瀛畞瀹濆疄瀹犲瀹瀹藉瀵濆瀵诲瀵垮皢灏斿皹灏у按灏稿敖灞傚眱灞夊眾灞炲薄灞﹀笨宀佸矀宀栧矖宀樺矙宀氬矝宀渤宀藉部宄冨硠宄″常宄ゅ偿宄﹀磦宕冨磩宕禈宓氬禌宓濆荡宸呭珐宸竵甯呭笀甯忓笎甯樺笢甯﹀抚甯副甯诲讣骞傚篂骞插苟骞垮簞搴嗗簮搴戝簱搴斿簷搴炲簾搴煎华寮€寮傚純寮犲讥寮集寮瑰己褰掑綋褰曞綗褰﹀交寰勫緯寰″繂蹇忓咖蹇炬€€鎬佹€傛€冩€勬€呮€嗘€滄€绘€兼€挎亱鎭虫伓鎭告伖鎭烘伝鎭兼伣鎮︽偒鎮偔鎮儕鎯ф儴鎯╂儷鎯儹鎯儻鎰嶆劆鎰ゆ劍鎰挎厬鎱喎鎳戞噿鎳旀垎鎴嬫垙鎴楁垬鎴埛鎵庢墤鎵︽墽鎵╂壀鎵壃鎵版姎鎶涙姛鎶犳姟鎶㈡姢鎶ユ媴鎷熸嫝鎷ｆ嫢鎷︽嫥鎷ㄦ嫨鎸傛寶鎸涙寽鎸濇尀鎸熸尃鎸℃將鎸ｆ尋鎸ユ對鎹炴崯鎹℃崲鎹ｆ嵁鎹绘幊鎺存幏鎺告幒鎺兼徃鎻芥徔鎼€鎼佹悅鎼呮惡鎽勬憛鎽嗘憞鎽堟憡鎾勬拺鎾垫挿鎾告捄鎿炴敀鏁屾暃鏁版枊鏂撴枟鏂╂柇鏃犳棫鏃舵椃鏃告槞鏄兼樈鏄炬檵鏅掓檽鏅旀檿鏅栨殏鏆ф湱鏈湸鏈烘潃鏉傛潈鏉℃潵鏉ㄦ潻鏉版瀬鏋勬灋鏋㈡灒鏋ユ灖鏋ㄦ灙鏋灜鏌滄煚鏌芥爛鏍呮爣鏍堟爥鏍婃爧鏍屾爭鏍忔爲鏍栨牱鏍炬妗犳　妗㈡。妗ゆˉ妗︽¨妗ㄦ々姊︽⒓姊炬妫傛妞熸妞ゆき妤兼姒囨姒夋妲涙妲犳í妯ū姗ユ┍姗规┘妾愭娆㈡娆ф娈佹畤娈嬫畳娈撴畾娈℃姣佹瘋姣曟瘷姣℃姘囨皵姘㈡癌姘叉眹姹夋薄姹ゆ惫娌撴矡娌℃玻娌ゆ播娌︽钵娌ㄦ博娌驳娉炴唱娉舵撤娉告澈娉绘臣娉芥尘娲佹磼娲兼祪娴呮祮娴囨祱娴夋祳娴嬫祶娴庢祻娴愭祽娴掓祿娴旀禃娑傛秾娑涙稘娑炴稛娑犳丁娑㈡叮娑ゆ鼎娑ф定娑╂穩娓婃笇娓嶆笌娓愭笐娓旀笘娓楁俯娓告咕婀挎簝婧呮簡婧囨粭婊氭粸婊熸粻婊℃虎婊ゆ互婊︽花婊╂华婕ゆ絾娼囨綃娼嶆綔娼存緶婵戞繏鐏忕伃鐏伒鐏剧伩鐐€鐐夌倴鐐滅倽鐐圭偧鐐界儊鐑傜儍鐑涚儫鐑︾儳鐑ㄧ儵鐑儸鐑剷鐒栫剺鐓呯叧鐔樼埍鐖风墠鐗︾壍鐗虹妸鐘熺姸鐘风姼鐘圭媹鐙嶇嫕鐙炵嫭鐙嫯鐙嫲鐙辩嫴鐚冪寧鐚曠尅鐚尗鐚尞鐛帒鐜欑帤鐜涚幃鐜幇鐜辩幒鐝夌弿鐝愮彂鐝扮彶鐞庣悘鐞愮惣鐟剁懛鐠囩拵鐡掔摦鐡數鐢荤晠鐣茬暣鐤栫枟鐤熺枲鐤＄柆鐤柉鐤辩柎鐥堢棄鐥掔棖鐥ㄧ棯鐥棿鐦呯槅鐦楃槝鐦槴鐦剧樋鐧炵櫍鐧櫙鐨戠毐鐨茬洀鐩愮洃鐩栫洍鐩樼湇鐪︾湰鐫€鐫佺潗鐫戠瀿鐬╃煫鐭剁熅鐭跨爛鐮佺爾鐮楃牃鐮滅牶鐮荤牼纭€纭佺纭曠纭楃纭氱‘纭风纰涚纰辩⒐纾欑ぜ绁庣ア绁シ绁哥绂勭绂荤绉嗙绉О绉界Ь绋嗙◣绋ｇǔ绌戠┓绐冪獚绐戠獪绐濈绐︾绔栫珵绗冪瑡绗旂瑫绗虹绗剧瓚绛氱瓫绛滅瓭绛圭绠€绠撶绠х绠╃绠瘧绡撶绡辩皷绫佺贝绫荤奔绮滅矟绮ょ勃绮硜绯囩揣绲风簾绾犵骸绾㈢海绾ょ亥绾︾骇绾ㄧ憨绾韩绾涵绾函绾扮罕绾茬撼绾寸旱绾剁悍绾哥汗绾虹夯绾肩航绾剧嚎缁€缁佺粋缁冪粍缁呯粏缁囩粓缁夌粖缁嬬粚缁嶇粠缁忕粣缁戠粧缁撶粩缁曠粬缁楃粯缁欑粴缁涚粶缁濈粸缁熺粻缁＄虎缁ｇ护缁ョ沪缁х花缁╃华缁滑缁划缁话缁辩徊缁崇淮缁电欢缁风桓缁圭缓缁荤患缁界痪缁跨紑缂佺紓缂冪紕缂呯紗缂囩紙缂夌紛缂嬬紝缂嶇紟缂忕紣缂戠紥缂撶紨缂曠紪缂楃紭缂欑細缂涚紲缂濈紴缂熺紶缂＄饥缂ｇ激缂ョ鸡缂х绩缂╃吉缂棘缂籍缂及缂辩疾缂崇即缂电絺缃戠綏缃氱舰缃寸緛缇熺尽缈樼繖缈氳€㈣€ц€歌€昏亗鑱嬭亴鑱嶈仈鑱╄仾鑲冭偁鑲よ偡鑲捐偪鑳€鑳佽儐鑳滆儳鑳ㄨ儶鑳兌鑴夎剭鑴忚剱鑴戣創鑴旇剼鑴辫劧鑴歌厞鑵岃厴鑵吇鑵艰吔鑵捐啈鑷滆垎鑸ｈ埌鑸辫埢鑹拌壋鑹硅壓鑺傝妶鑺楄姕鑺﹁媮鑻囪媹鑻嬭媽鑻嶈嫀鑻忚嫎鑻硅寧鑼忚寫鑼旇寱鑼ц崋鑽愯崣鑽氳崨鑽滆崬鑽熻崰鑽¤崳鑽よ崶鑽﹁崸鑽ㄨ崺鑽崼鑽嵀鑽嵂鑾呰帨鑾辫幉鑾宠幋鑾惰幏鑾歌幑鑾鸿幖钀氳悵钀よ惀钀﹁惂钀ㄨ懕钂囪拤钂嬭拰钃濊摕钃犺摚钃ヨ摝钄疯敼钄鸿敿钑茶暣钖梺钘撹檹铏戣櫄铏櫖铏櫧铏捐櫩铓€铓佽殏铓曡殱铓泭铔庤洀铔洶铔辫洸铔宠洿铚曡湕铚¤潎铦堣潐铦庤澕铦捐瀫铻ㄨ煆琛呰琛ヨ‖琛琚呰琚滆琚瑁嗚瑁㈣＃瑁よ％瑜涜ご瑗佽瑙佽瑙冭瑙呰瑙囪瑙夎瑙嬭瑙嶈瑙忚瑙戣瑙﹁Н瑭熻獕瑾婅疇璁¤璁ｈ璁ヨ璁ц璁╄璁璁璁拌璁茶璁磋璁惰璁歌璁鸿璁艰璁捐璇€璇佽瘋璇冭瘎璇呰瘑璇囪瘓璇夎瘖璇嬭瘜璇嶈瘞璇忚瘣璇戣瘨璇撹瘮璇曡瘱璇楄瘶璇欒瘹璇涜瘻璇濊癁璇熻癄璇¤璇ｈ璇ヨ璇ц璇╄璇璇璇璇辫璇宠璇佃璇疯璇硅璇昏璇借璇胯皜璋佽皞璋冭皠璋呰皢璋囪皥璋婅皨璋岃皪璋庤皬璋愯皯璋掕皳璋旇皶璋栬皸璋樿皺璋氳皼璋滆皾璋炶盁璋犺啊璋㈣埃璋よ哎璋﹁哀璋ㄨ癌璋矮璋碍璋隘璋拌氨璋茶俺璋磋暗璋惰胺璞礉璐炶礋璐犺础璐㈣矗璐よ触璐﹁揣璐ㄨ穿璐传璐喘璐疮璐拌幢璐茶闯璐磋吹璐惰捶璐歌垂璐鸿椿璐艰唇璐捐纯璧€璧佽祩璧冭祫璧呰祮璧囪祱璧夎祳璧嬭祵璧嶈祹璧忚祼璧戣祾璧撹禂璧曡禆璧楄禈璧欒禋璧涜禍璧濊禐璧熻禒璧¤耽璧ｈ氮璧佃刀瓒嬭侗瓒歌穬璺勮窎璺炶返璺惰贩璺歌饭璺昏笂韪岃釜韪腐韫戣箳韫拌箍韬忚簻韬溅杞ц建杞╄姜杞浆杞疆杞桨杞辫讲杞宠酱杞佃蕉杞疯礁杞硅胶杞昏郊杞借骄杞胯線杈佽緜杈冭緞杈呰締杈囪緢杈夎緤杈嬭緦杈嶈編杈忚緪杈戣緬杈撹緮杈曡緰杈楄緲杈欒練杈炶京杈竟杈借揪杩佽繃杩堣繍杩樿繖杩涜繙杩濊繛杩熻咯杩宠抗閫傞€夐€婇€掗€﹂€婚仐閬ラ倱閭濋偓閭偣閭洪偦閮侀儎閮忛儛閮戦儞閮﹂儳閮搁厺閰﹂叡閰介吘閰块噴閲岄墔閴撮姰閷鹃拞閽囬拡閽夐拪閽嬮拰閽嶉拵閽忛拹閽戦拻閽撻挃閽曢挅閽楅挊閽欓挌閽涢挐閽為挓閽犻挕閽㈤挘閽ら挜閽﹂挧閽ㄩ挬閽挮閽挱閽挴閽伴挶閽查挸閽撮挼閽堕挿閽搁捁閽洪捇閽奸捊閽鹃捒閾€閾侀搨閾冮搫閾呴搯閾堥搲閾婇搵閾嶉搸閾忛搻閾戦搾閾曢摋閾橀摍閾氶摏閾滈摑閾為摕閾犻摗閾㈤摚閾ら摜閾﹂摟閾ㄩ摢閾摤閾摦閾摪閾遍摬閾抽摯閾甸摱閾烽摳閾归摵閾婚摷閾介摼閾块攢閿侀攤閿冮攧閿呴攩閿囬攬閿夐攰閿嬮攲閿嶉攷閿忛攼閿戦敀閿撻敂閿曢敄閿楅敊閿氶敎閿為敓閿犻敗閿㈤敚閿ら敟閿﹂敤閿╅敨閿敪閿敮閿伴敱閿查敵閿撮數閿堕敺閿搁敼閿洪敾閿奸斀閿鹃斂闀€闀侀晜闀冮晢闀囬晥闀夐晩闀岄晬闀庨晱闀愰晳闀掗晻闀栭晽闀欓暁闀涢暅闀濋暈闀熼暊闀￠暍闀ｉ暏闀ラ暒闀ч暔闀╅暘闀暚闀暜闀暟闀遍暡闀抽暣闀堕暱闂ㄩ棭闂棲闂棴闂棷闂伴棻闂查棾闂撮椀闂堕椃闂搁椆闂洪椈闂奸椊闂鹃椏闃€闃侀槀闃冮槃闃呴槅闃囬槇闃夐槉闃嬮槍闃嶉槑闃忛槓闃戦槖闃撻様闃曢槚闃楅槝闃欓槡闃涢槦闃抽槾闃甸樁闄呴檰闄囬檲闄夐檿闄ч櫒闄╅殢闅愰毝闅介毦闆忛洜闆抽浘闇侀湁闇潛闈欓潵闉戦瀿闉灤闊﹂煣闊ㄩ煩闊煫闊煹椤甸《椤烽「椤归『椤婚〖椤介【椤块棰侀棰冮棰呴棰囬棰夐棰嬮棰嶉棰忛棰戦棰撻棰曢棰楅棰欓棰涢棰濋棰熼棰￠ⅱ棰ｉⅳ棰ラⅵ棰ч椋忛椋戦椋撻椋曢椋楅椋欓椋為（椁嶉イ楗ラウ楗чエ楗╅オ楗ガ楗ギ楗グ楗遍ゲ楗抽ゴ楗甸ザ楗烽ジ楗归ズ楗婚ゼ楗介ゾ楗块棣侀棣冮棣呴棣囬棣夐棣嬮棣嶉棣忛棣戦棣撻棣曢┈椹┊椹┌椹遍┎椹抽┐椹甸┒椹烽└椹归┖椹婚┘椹介┚椹块獉楠侀獋楠冮獎楠呴獑楠囬獔楠夐獖楠嬮獙楠嶉獛楠忛獝楠戦獟楠撻獢楠曢獤楠楅獦楠欓獨楠涢獪楠濋獮楠熼獱楠￠楠ｉ楠ラ楠ч珔楂嬮珜楝撻瓏榄夐奔楸介本楸块瞼椴侀矀椴勯矃椴嗛矅椴堥矇椴婇矉椴岄矋椴庨矎椴愰矐椴掗矒椴旈矔椴栭矖椴橀矙椴氶矝椴滈矟椴為矡椴犻病椴㈤玻椴ら播椴﹂钵椴ㄩ博椴搏椴箔椴帛椴伴脖椴查渤椴撮驳椴堕卜椴搁补椴洪不椴奸步椴鹃部槌€槌侀硞槌冮硠槌呴硢槌囬硤槌夐硦槌嬮硨槌嶉硯槌忛硱槌戦硳槌撻硵槌曢硸槌楅硺槌欓硾槌滈碀槌為碂槌犻场槌㈤常楦熼笭楦￠涪楦ｉ袱楦ラ甫楦ч辅楦╅釜楦脯楦府楦赴楦遍覆楦抽复楦甸付楦烽父楦归负楦婚讣楦介妇楦块箑楣侀箓楣冮箘楣呴箚楣囬箞楣夐箠楣嬮箤楣嶉箮楣忛箰楣戦箳楣撻箶楣曢箹楣楅箻楣氶箾楣滈節楣為篃楣犻埂楣㈤梗楣ら攻楣﹂恭楣ㄩ供楣公楣弓楣拱楣遍共楣抽勾楣鹃害楹搁粍榛夐弧榛╅华榛鹃紜榧岄紞榧楅脊榻勯綈榻戦娇榫€榫侀緜榫冮緞榫呴締榫囬緢榫夐緤榫嬮緦榫欓練榫涢緹蹇楀埗鍜ㄥ彧閲岀郴鑼冩澗娌″皾灏濋椆闈㈠噯閽熷埆闂插共灏借剰鎷�');

    /**
     * 绻佷綋瀛�
     * @const
     */
    var T = new String('钀垏閱滃皥妤彚鏉辩挡涓熷叐鍤村柂鍊嬬埧璞愯嚚鐐洪簵鑸夐杭缇╃儚妯傚柆缈掗剦鏇歌卜浜傜埈鏂艰櫑闆蹭簷浜炵敘鐣濊Κ瑜诲毑鍎勫儏寰炰緰鍊夊剙鍊戝児鐪惧劒澶ユ渻鍌村倶鍋夊偝鍌峰€€鍊倴鍋戒絿楂旈鍌儔淇犱径鍍ュ伒鍋村儜鍎堝剷鍎備縼鍎斿劶鍊嗗劮鍎夊偟鍌惧偗鍍傚儴鍎熷劵鍎愬劜鍎哄厭鍏屽厳榛ㄨ槶闂滆垐鑼查鐛稿泤鍏у病鍐婂杌嶈静濉氶Ξ琛濇焙娉佸噸娣ㄦ窉娑兼珐娓涙箠鍑滃咕槌抽厂鎲戝嚤鎿婃肮閼胯娀鍔冨妷鍓囧墰鍓靛埅鍒ュ墬鍓勫妸鍔屽壌鍔戝壆鍔嶅墲鍔囧嫺杈﹀嫏鍕卞嫊鍕靛媮鍕炲嫝鍕崇寷鍕╁嫽鍖尡鍗€閱彲鍗斿柈璩ｇ洤楣佃嚗琛涘嵒宸瑰粻寤虫泦鍘插鍘帣寤佸粋鍘村粓寤氬粍寤濈福鍙冮潐闈嗛洐鐧艰畩鏁樼枈钁夎櫉姝庡槹绫插緦鍤囧憘鍡庡敋鍣歌伣鍟熷惓鍢稿泩鍢斿殾鍞勫摗鍜煎梿鍡氳鍝㈠毃鍤€鍣濆悞鍣呴构鍛遍熆鍟炲櫊鍢靛椂鍣﹀槱鍣插殞鍣ュ柌鍢滃棅鍢暍鍡╁敃鍠氬懠鍢栧棁鍥€榻у泬鍢藉槸鍣村槏鍤冲泚鍡櫙鍣撳毝鍥戝殨鍔堝泜璎斿湗鍦掑洩鍦嶅渿鍦嬪湒鍦撹仏澹欏牬闃濉婂爡澹囧＂澹╁、澧冲澹熷澹氬澧惧澃鍫婂鍩″⒍澹嬪鍫栧濉ゅ牆澧婂灥濉瑰澹墕澹伈娈煎：澹艰檿鍌欒澶犻牠瑾囧ぞ濂ォ濂愬ギ鐛庡ェ濡濆│濯藉瀚楀濮嶈枒濠佸┉瀣堝瑢瀛屽濯у瀚垮瀣嬪濯煎瀣瑱瀣ゅ瀛稿瀵у瀵﹀瀵╂啿瀹璩撳灏嶅皨灏庡＝灏囩埦濉靛牤灏峰睄鐩″堡灞睖灞嗗爆灞㈠报宥兼璞堝秶宕楀炒宥村祼宄跺逗宥藉礌宸嬪定宥у辰宥㈠稜宕㈠窉宥楀磵宥秳宥稿稊宕冲秮鑴婂窋闉忓钒骞ｅ弗甯箖甯崇熬骞熷付骞€骞宫骞樺箺鍐骞逛甫寤ｈ帄鎱跺滑寤″韩鎳夊粺榫愬虎寤庡哗闁嬬暟妫勫嫉褰屽汲褰庡綀寮锋鐣堕寗褰犲渐寰瑰緫寰犵Ζ鎲舵嚭鎲傛劸鎳锋厠鎱啴鎱偟鎰存啇绺芥嚐鎳屾垁鎳囨儭鎱熸嚚鎰锋兓鎯辨儾鎮呮劏鎳告叧鎲鎳兼厴鎳叉唺鎰滄厷鎲氭叄婀ｆ厤鎲ゆ啋椤樻嚲鎲栨€垫嚕鎳舵噸鎴囨垟鎴叉埀鎴版埄鎴剁串鎾叉墶鍩锋摯鎹巸鎻氭摼鎾媼鎽舵懗鎺勬惗璀峰牨鎿旀摤鏀忔弨鎿佹敂鎿版挜鎿囨帥鎽敚鎺楁捑鎾绘尵鎾撴搵鎾熸帣鎿犳彯鎾忔拡鎼嶆捒鎻涙悧鎿氭挌鎿勬憫鎿叉挘鎽绘憸鎽ｆ敩鎾虫敊鎿辨憻鏀敎鏀濇攧鎿烘悥鎿敜鏀栨拹鏀嗘摲鎿兼敍鎿绘敘鏁垫杺鏁搁綃鏂曢鏂柗鐒¤垔鏅傛洜鏆樻泧鏅濇洦椤檳鏇泬鏇勬殘鏆夋毇鏇栧妱琛撴ǜ姗熸闆滄瑠姊濅締妤婃Κ鍌戞サ妲嬫▍妯炴娅妫栨妤撴娅冩妾夋鏌垫妫ф珱娅虫娅ㄦ珶娆勬ü妫叉ǎ娆掓，妞忔﹫妤ㄦ獢姒挎妯烘獪妲虫▉澶㈡妫舵娆炴Ж娅濇Ё娆忔妯撴瑬娅珰娅告獰妾绘娅ф┇妾ｆ娅娅撴珵绨锋獊姝℃瓱姝愭姝挎娈樻疄娈娈瘑姣€杞傜暍鏂冩皥姣挎皩姘ｆ矮姘俺褰欐饥姹欐汞娲堕仢婧濇矑鐏冩細鐎濇藩婊勬涪婧堟滑婵旀繕娣氭京鐎х€樻考鐎夋綉婢ゆ秶娼旂亼绐倒娣烘伎婢嗘篂婧縼娓井婵熺€忔换娓炬桓婵冩蒋婵滃婀ф郡婢囨范婕ｆ娇娓︽撼娓欐粚娼ゆ緱婕叉線婢辨返娣ユ棘鐎嗘几婢犳紒鐎嬫徊婧亰鐏ｆ繒娼版亢婕垫紛娼锋痪婊仼鐏勬豢鐎呮烤婵仱婵辩仒婢︽揩鐎犵€熺€叉堪娼涚€︾€剧€ㄧ€曠仢婊呯噲闈堢伣鐕︾叕鐖愮噳鐓掔啑榛炵厜鐔剧垗鐖涚兇鐕厵鐓╃噿鐕佺嚧鐕欑嚰鐔辩叆鐕滅嚲鐓嗙硦婧滄剾鐖虹墭鐘涚壗鐘х姠寮风媭鐛风崄鐚剁嫿楹呯嵁鐛扮崹鐙圭崊鐛寵鐛勭尰鐛嵉鐛肩巰璞矒铦熺嵒鐛虹挘鐠电憭鐟憢鐠扮従鐟茬捊鐟夌帹鐞虹搹鐠惪鐠＄拤鐟ｇ搳鐟ょ挦鐠跨摂鐡氱敃鐢岄浕鐣殺浣樼枃鐧ょ檪鐦х櫂鐦嶉瑏鐦＄構鐨板睓鐧扮棛鐧㈢槀鐧嗙槗鐧囩櫋鐧夌槷鐦炵樅鐧熺櫛鐧櫗鐧╃櫖鐧茶噿鐨氱毢鐨哥洖楣界洠钃嬬洔鐩ょ灅鐪ョ煋钁楃潨鐫炵灱鐬炵煔鐭／绀う纰⒓纾氱〃纭⒏绀け绀纭滅熃纰╃·纾界绀勭⒑楣肩纾х＃鍫块暉婊剧Ξ绂曠Π绂庣Ρ绂嶇绁跨Κ闆㈢绋堢ó绌嶇ū绌㈢绌▍绌岀┅绌＄绔婄珔绐珓绐╃绔囩璞庣绡ょ瓖绛嗙绠嬬睜绫╃瘔绡崇绨圭畯绫岀敖绨＄睓绨€绡嬬睖绫盀绨埃绨嶇眱绫豹绫熺炒椤炵绯剁巢绮电碁绯х碀椁辩穵绺剁掣绯剧磫绱呯磦绾栫磭绱勭礆绱堢簥绱€绱夌矾绱滅礃绱旂磿绱楃侗绱嶇礉绺辩陡绱涚礄绱嬬础绱电礀绱愮磽绶氱春绲忕幢绶寸祫绱崇窗绻旂祩绺愮祮绱肩祤绱圭构缍撶纯缍佺胆绲愮禎绻炵蛋绲庣躬绲︾耽绲崇怠绲曠禐绲辩秵缍冪倒绻＄秾缍忕禌绻肩秷绺剧窉缍剧窊绾岀逗绶嬬督绶旂穭绻╃董缍跨冬绻冪盯缍豆缍ｇ稖缍荤栋缍犵洞绶囩窓绶楃窐绶簻绶圭凡绶濈笗绻㈢乏缍炵窞绶剁窔绶辩笅绶╃窢绺风法绶＄罚绺夌笡绺熺笣绺笚绺炵簭绺笂绺戠菇绺圭傅绺茬簱绺箚绻呯簣绻氱箷绻掗焷绻剧拱绻钩绾樼綄缍茬緟缃扮椒缇嗙緢缇ョ鲸缈圭拷缈€€伋鎭ヨ伓鑱捐伔鑱硅伅鑱佃伆鑲呰吀鑶氳唩鑵庤叓鑴硅剠鑶藉嫕鏈ц厲鑷氳剾鑶犺剤鑶鹃珤鑷嶈叇鑶胯嚑鑵宠劔鑵¤噳鑷橀唭鑶曢蕉鑶╅潶鑶冮ò鑷忚嚔杓胯墹鑹﹁墮鑹壉璞旇壐钘濈瘈缇嬭枌钑槅钃懄钘惰帶钀囪捈鑻ц槆妾捐構鑾栬槩钄﹀鐓㈢弓鑽婅枽钖樿帰钑樿摻钑庤枅钖鸿暕姒懛婊庣姈鐔掕晛钘庤搥钄晵钁掕懁钘ヨ挒钃ц悐钃挃钀佃枱鐛茶晻鐟╅动钃磋榾铇胯灑鐕熺笀钑柀钄ヨ晢钑㈣敚钄炶棈钖婅樅钑烽帲椹€钖旇槥钘鸿椆铇勮槉钘铇氳櫆鎱櫅锜茶櫙锜ｉ洊铦﹁爢铦曡熁铻炶牰锠旇渾锠辫牐锜惰牷锜勮浐锜瀯锠愯浕铦歌牊锠呰焾锜爫铻昏爲铻胯煄锠ㄩ噥閵滆瑗瑗栧珛瑜樿オ瑗茶瑁濊瑜岃こ瑗濊げ瑗囪じ瑗ょ箞瑗磋瑙€瑕庤瑕撹瑕樿瑕鸿Μ瑕¤瑕ヨΖ瑕Σ瑕疯Т瑙歌Ф璁嬭璎勮▉瑷堣▊瑷冭獚璀忚◥瑷岃◣璁撹〞瑷栬〒璀拌▕瑷樿⊕璎涜璎宠瑷濊ē瑷辫璜栬ī瑷熻瑷í瑷ｈ瓑瑭佽ǘ瑭曡璀樿瑭愯ù瑷鸿﹩璎呰瑭樿瑭栬瑭掕獑瑾勮│瑭胯┅瑭拌┘瑾犺獏瑭佃┍瑾曡┈瑭┉瑭㈣璜嶈┎瑭宠┇璜㈣璀歌瑾ｈ獮瑾氳瑾ヨ獦瑾ㄨ獞瑾瑾掕珛璜歌珡璜捐畝璜戣瑾茶珘璜涜璜楄璜傝珤璜勮璜囪璎€璜惰珳璎婅璜ц瑪璎佽瑐璜よ璜艰畳璜璜鸿璎庤珵璜濊璁滆瑬璎濊瑺璎楄璎欒瑦璎硅璎璎瓪璀栬瓩璁曡瓬璀庤疄璀磋璁栫﹢璞惰矟璨炶矤璨熻并璨¤铂璩㈡晽璩波璩博璨钵璨惰臣璨搏璨宠长璩佽舶璨艰泊璨鸿哺璨胯不璩€璨借硦璐勮硤璩勮膊璩冭硞璐撹硣璩呰磹璩曡硲璩氳硳璩﹁抄榻庤礀璩炶硿璐旇硻璩¤碃璩ц炒璩佃磪璩昏澈璩借尘璐楄畾璐囪磮璐嶈磸璐涜惮瓒欒稌瓒ㄨ恫韬夎簫韫岃範韬掕笎韬傝购韫曡簹韬嬭复韬婅工韬撹簯韬¤梗韬曡亥韬害杌€杌婅粙杌岃粧杌戣粩杞夎粵杓粺杞熻徊杌昏饯杌歌还杌艰护杌舰杌鸿紩杌捐級杓婅綆杓堣紘杓呰純杓掕紨杓涜鸡杓╄紳杓ヨ紴杓紵杓滆汲杓昏集杞€杓歌健杞呰絼杓捐絾杞嶈綌杈警杈倞閬奸仈閬烽亷閭侀亱閭勯€欓€查仩閬曢€ｉ伈閭囬€曡贰閬╅伕閬滈仦閭愰倧閬洪仚閯ч労閯旈兊閯掗劥閯伴閮ら儫閯堕劖閯嗛厛閯栭劜閱為啽閱噮閲冮噣閲嬭閽滈憭閼鹃彣閲撻嚁閲濋嚇閲楅嚈閲曢嚪閲洪嚙閲ら垝閲╅嚕閸嗛嚬閸氶嚨閳冮垼閳堥垿閳嶉垟閸鹃垑閶囬嫾閳戦垚閼版閳為帰閴ら埀閳侀垾閳勯垥閳€閳洪將閴﹂墬閳风冀閳抽墪閳介埜閴為懡閴壄閴€閳块埦閻甸墤閳撮憼閴涢墯閳伴墘閴堥墠閳归惛閴堕姮閵犻壓閵嫃閶ｉ悆閵嶉惡閵呴媮閵遍姦閹ч崢閵栭姂閶岄姪閵涢彽閵撻壙閵氶壔閵橀寶閵壐閵ラ彑閵冮悑閵ㄩ妧閵ｉ憚閻掗嫪閶欓尭閶遍張閺楅姺閹栭嫲閶ラ嫟閸嬮嫰閶ㄩ徑閵奸嫕閶掗媴閶堕惁閻ч姵閵婚媰閶熼嫤閷掗寙閸洪尟閷ㄩ尅閷侀寱閷╅尗閷懠閷橀寪閷﹂崄閷堥寚閷熼尃閸甸嫺閷抽寵閸ラ崍閸囬彉閸堕崝閸ら崿閸鹃崨閹崰閸伴巹閸嶉巶閺ら帯閺岄幃閹涢帢閼烽惈閹抽幙閹﹂幀閹婇幇閹旈彚閺滈弽閺伴彏閺￠彂閺冮弴閺愰悢閽侀悙閺烽懃閻撻懎閻犻懝閺归悪閼婇惓閻堕惒閻惪閼旈懀閼為懖闀烽杸闁傞杻闁嗛枅闁夊晱闂栭枏闂堥枒闁庨枔闁旈枌鎮堕枠楝ч枿鑱為棩闁╅柇闂撻枼闁ｉ枴闁闁遍柆闂嶉柧闁归柖楝╅柨闁介柣闁奸棥闂岄梼闂犻棅闂嬮棓闂愰棐闂曢棡闂ら殜闄介櫚闄ｉ殠闅涢櫢闅撮櫝闄橀櫇闅夐殨闅毃闅遍毟闆嬮洠闆涜畮闈傞湩闇介淮闈勯潥闈滈潹闊冮灲闊夐煗闊嬮煂闊嶉煋闊欓煘闊滈熁闋侀爞闋冮爣闋呴爢闋堥爦闋戦¨闋撻爭闋掗爩闋忛爯椤遍牁闋楅牳闋￠牥闋查牅娼佺啿闋﹂牑闋婚牣闋归牱闋寸椤嗛椤掗椤撻椤嶉〕椤㈤椤欓ˉ绾囬～椤“椤撮ⅷ棰洪棰棰堕⒏棰奸⒒椋€椋勯椋嗛楗楅椋ｉ椋ラこ椋╅ぜ椋＋椋／椋查椋鹃＝椋奸？椋撮楗掗椁勯椁冮椁呴椁栭椁橀椁曢椁涢ぁ椁ㄩし楗嬮ざ椁块楗侀椁洪ぞ楗堥楗呴楗岄ア棣Ν棣遍Υ棣抽﹨棣归椹㈤椐涢椐欓楱堕椐濋椐曢椐橀缃甸О椹曢椐遍Л椐㈤┇椹▉椹楅▊椐搁Э楱忛◣楱嶉▍楱岄椹傞楱à楱烽椹侀ó楱ǜ椹冮ň椹勯椹熼━椹﹂─楂忛珫楂曢榄橀瓗榄氶瓫榄㈤榄ㄩ榄撮楫侀畠榀伴备楫嬮畵楫掗畩楫戦睙楫嶉異楫畾楫抽楫為榘傞疁楸犻杯楫楫洪瘲楸橀瘉楸洪氨榘归瘔榘ｉ胺榀€榀婇瘒楫堕榀掗瘱榀瘯榀榀ら榀濋榀伴瘺榀ㄩ榀撮瘮楸濋皥榘忛报榀烽爱榘冮皳楸烽皪榘掗皦榘侀眰榀块盃榧囬碍榘ㄩ哎榘╅盁榘滈俺榘鹃眻楸夐盎榘甸眳榘奸睎楸旈睏楸掗悲楸ら抱楸ｉ偿槌╅洖槌堕炒槌查窏榇夐冬榇囬磫榇ｉ秶楦曢川榇為处榇掗礋榇濋礇榇磿榉ラ窓榇窗榈傞创榈冮纯楦為椿榈愰祿楦濋祽榈犻禎榈掗烦榈滈怠榈查稉榈钉榈惮榈秹槎婇捣榉稑槎￠稓槎婚犊槎ラ订榉婇穫槎查豆槎洪穪槎奸洞榉栭笟榉撻窔榉乏榉查犯榉洪竾榉归笇楦忛笡楦橀购楹ラ憨榛冮粚榛堕环榛查唤榛块紓榧夐瀫榧撮絿榻婇綇榻掗綌榻曢綏榻熼健榻欓綘榻滈溅榻姜榻查椒榫嶉緮榫曢緶瑾岃＝璋橀毣瑁′總绡勯瑔鍐囧殣鍢楅楹垫簴閻樺絾闁掍咕鍎樿嚐鎷�');

    /**
     * 杞崲鏂囨湰
     * @param {String} str - 寰呰浆鎹㈢殑鏂囨湰
     * @param {Boolean} toT - 鏄惁杞崲鎴愮箒浣�
     * @returns {String} - 杞崲缁撴灉
     */
    function tranStr(str, toT) {
        var i;
        var letter;
        var code;
        var isChinese;
        var index;
        var src, des;
        var result = '';

        if (toT) {
            src = S;
            des = T;
        } else {
            src = T;
            des = S;
        }

        if (typeof str !== "string") {
            return str;
        }

        for (i = 0; i < str.length; i++) {
            letter = str.charAt(i);
            code = str.charCodeAt(i); 
            
            // 鏍规嵁瀛楃鐨刄nicode鍒ゆ柇鏄惁涓烘眽瀛楋紝浠ユ彁楂樻€ц兘
            // 鍙傝€�:
            // [1] http://www.unicode.org
            // [2] http://zh.wikipedia.org/wiki/Unicode%E5%AD%97%E7%AC%A6%E5%88%97%E8%A1%A8
            // [3] http://xylonwang.iteye.com/blog/519552
            isChinese = (code > 0x3400 && code < 0x9FC3) || (code > 0xF900 && code < 0xFA6A);

            if (!isChinese) {
                result += letter;
                continue;
            }

            index = src.indexOf(letter);

            if (index !== -1) {
                result += des.charAt(index);
            } else {
                result += letter;
            }
        }

        return result;
    }

    /**
     * 杞崲HTML Element灞炴€�
     * @param {Element} element - 寰呰浆鎹㈢殑HTML Element鑺傜偣
     * @param {String|Array} attr - 寰呰浆鎹㈢殑灞炴€�/灞炴€у垪琛�
     * @param {Boolean} toT - 鏄惁杞崲鎴愮箒浣�
     */
    function tranAttr(element, attr, toT) {
        var i, attrValue;

        if (attr instanceof Array) {
            for(i = 0; i < attr.length; i++) {
                tranAttr(element, attr[i], toT);
            }
        } else {
            attrValue = element.getAttribute(attr);

            if (attrValue !== "" && attrValue !== null) {
                element.setAttribute(attr, tranStr(attrValue, toT));
            }
        }
    }

    /**
     * 杞崲HTML Element鑺傜偣
     * @param {Element} element - 寰呰浆鎹㈢殑HTML Element鑺傜偣
     * @param {Boolean} toT - 鏄惁杞崲鎴愮箒浣�
     */
    function tranElement(element, toT) {
        var i;
        var childNodes;

        if (element.nodeType !== 1) {
            return;
        }

        childNodes = element.childNodes;

        for (i = 0; i < childNodes.length; i++) {
            var childNode = childNodes.item(i);

            // 鑻ヤ负HTML Element鑺傜偣
            if (childNode.nodeType === 1) {
                // 瀵逛互涓嬫爣绛句笉鍋氬鐞�
                if ("|BR|HR|TEXTAREA|SCRIPT|OBJECT|EMBED|".indexOf("|" + childNode.tagName + "|") !== -1) {
                    continue;
                }
                
                tranAttr(childNode, ['title', 'data-original-title', 'alt', 'placeholder'], toT);

                // input 鏍囩
                // 瀵箃ext绫诲瀷鐨刬nput杈撳叆妗嗕笉鍋氬鐞�
                if (childNode.tagName === "INPUT"
                    && childNode.value !== ""
                    && childNode.type !== "text"
                    && childNode.type !== "hidden")
                {
                    childNode.value = tranStr(childNode.value, toT);
                }

                // 缁х画閫掑綊璋冪敤
                tranElement(childNode, toT);
            } else if (childNode.nodeType === 3) {  // 鑻ヤ负鏂囨湰鑺傜偣
                childNode.data = tranStr(childNode.data, toT);
            }
        }
    }

    // 鎵╁睍jQuery鍏ㄥ眬鏂规硶
    $.extend({
        /**
         * 鏂囨湰绠€杞箒
         * @param {String} str - 寰呰浆鎹㈢殑鏂囨湰
         * @returns {String} 杞崲缁撴灉
         */
        s2t: function(str) {
            return tranStr(str, true);
        },

        /**
         * 鏂囨湰绻佽浆绠€
         * @param {String} str - 寰呰浆鎹㈢殑鏂囨湰
         * @returns {String} 杞崲缁撴灉
         */
        t2s: function(str) {
            return tranStr(str, false);
        }
    });

    // 鎵╁睍jQuery瀵硅薄鏂规硶
    $.fn.extend({
        /**
         * jQuery Objects绠€杞箒
         * @this {jQuery Objects} 寰呰浆鎹㈢殑jQuery Objects
         */
        s2t: function() {
            return this.each(function() {
                tranElement(this, true);
            });
        },

        /**
         * jQuery Objects绻佽浆绠€
         * @this {jQuery Objects} 寰呰浆鎹㈢殑jQuery Objects
         */
        t2s: function() {
            return this.each(function() {
                tranElement(this, false);
            });
        }
    });
}) (jQuery);

/**
 * Swiper 3.4.2
 * Most modern mobile touch slider and framework with hardware accelerated transitions
 * 
 * http://www.idangero.us/swiper/
 * 
 * Copyright 2017, Vladimir Kharlampidi
 * The iDangero.us
 * http://www.idangero.us/
 * 
 * Licensed under MIT
 * 
 * Released on: March 10, 2017
 */
!function(){"use strict";var e,a=function(t,s){function r(e){return Math.floor(e)}function i(){var e=x.params.autoplay,a=x.slides.eq(x.activeIndex);a.attr("data-swiper-autoplay")&&(e=a.attr("data-swiper-autoplay")||x.params.autoplay),x.autoplayTimeoutId=setTimeout(function(){x.params.loop?(x.fixLoop(),x._slideNext(),x.emit("onAutoplay",x)):x.isEnd?s.autoplayStopOnLast?x.stopAutoplay():(x._slideTo(0),x.emit("onAutoplay",x)):(x._slideNext(),x.emit("onAutoplay",x))},e)}function n(a,t){var s=e(a.target);if(!s.is(t))if("string"==typeof t)s=s.parents(t);else if(t.nodeType){var r;return s.parents().each(function(e,a){a===t&&(r=t)}),r?t:void 0}if(0!==s.length)return s[0]}function o(e,a){a=a||{};var t=window.MutationObserver||window.WebkitMutationObserver,s=new t(function(e){e.forEach(function(e){x.onResize(!0),x.emit("onObserverUpdate",x,e)})});s.observe(e,{attributes:void 0===a.attributes||a.attributes,childList:void 0===a.childList||a.childList,characterData:void 0===a.characterData||a.characterData}),x.observers.push(s)}function l(e){e.originalEvent&&(e=e.originalEvent);var a=e.keyCode||e.charCode;if(!x.params.allowSwipeToNext&&(x.isHorizontal()&&39===a||!x.isHorizontal()&&40===a))return!1;if(!x.params.allowSwipeToPrev&&(x.isHorizontal()&&37===a||!x.isHorizontal()&&38===a))return!1;if(!(e.shiftKey||e.altKey||e.ctrlKey||e.metaKey||document.activeElement&&document.activeElement.nodeName&&("input"===document.activeElement.nodeName.toLowerCase()||"textarea"===document.activeElement.nodeName.toLowerCase()))){if(37===a||39===a||38===a||40===a){var t=!1;if(x.container.parents("."+x.params.slideClass).length>0&&0===x.container.parents("."+x.params.slideActiveClass).length)return;var s={left:window.pageXOffset,top:window.pageYOffset},r=window.innerWidth,i=window.innerHeight,n=x.container.offset();x.rtl&&(n.left=n.left-x.container[0].scrollLeft);for(var o=[[n.left,n.top],[n.left+x.width,n.top],[n.left,n.top+x.height],[n.left+x.width,n.top+x.height]],l=0;l<o.length;l++){var p=o[l];p[0]>=s.left&&p[0]<=s.left+r&&p[1]>=s.top&&p[1]<=s.top+i&&(t=!0)}if(!t)return}x.isHorizontal()?(37!==a&&39!==a||(e.preventDefault?e.preventDefault():e.returnValue=!1),(39===a&&!x.rtl||37===a&&x.rtl)&&x.slideNext(),(37===a&&!x.rtl||39===a&&x.rtl)&&x.slidePrev()):(38!==a&&40!==a||(e.preventDefault?e.preventDefault():e.returnValue=!1),40===a&&x.slideNext(),38===a&&x.slidePrev()),x.emit("onKeyPress",x,a)}}function p(e){var a=0,t=0,s=0,r=0;return"detail"in e&&(t=e.detail),"wheelDelta"in e&&(t=-e.wheelDelta/120),"wheelDeltaY"in e&&(t=-e.wheelDeltaY/120),"wheelDeltaX"in e&&(a=-e.wheelDeltaX/120),"axis"in e&&e.axis===e.HORIZONTAL_AXIS&&(a=t,t=0),s=10*a,r=10*t,"deltaY"in e&&(r=e.deltaY),"deltaX"in e&&(s=e.deltaX),(s||r)&&e.deltaMode&&(1===e.deltaMode?(s*=40,r*=40):(s*=800,r*=800)),s&&!a&&(a=s<1?-1:1),r&&!t&&(t=r<1?-1:1),{spinX:a,spinY:t,pixelX:s,pixelY:r}}function d(e){e.originalEvent&&(e=e.originalEvent);var a=0,t=x.rtl?-1:1,s=p(e);if(x.params.mousewheelForceToAxis)if(x.isHorizontal()){if(!(Math.abs(s.pixelX)>Math.abs(s.pixelY)))return;a=s.pixelX*t}else{if(!(Math.abs(s.pixelY)>Math.abs(s.pixelX)))return;a=s.pixelY}else a=Math.abs(s.pixelX)>Math.abs(s.pixelY)?-s.pixelX*t:-s.pixelY;if(0!==a){if(x.params.mousewheelInvert&&(a=-a),x.params.freeMode){var r=x.getWrapperTranslate()+a*x.params.mousewheelSensitivity,i=x.isBeginning,n=x.isEnd;if(r>=x.minTranslate()&&(r=x.minTranslate()),r<=x.maxTranslate()&&(r=x.maxTranslate()),x.setWrapperTransition(0),x.setWrapperTranslate(r),x.updateProgress(),x.updateActiveIndex(),(!i&&x.isBeginning||!n&&x.isEnd)&&x.updateClasses(),x.params.freeModeSticky?(clearTimeout(x.mousewheel.timeout),x.mousewheel.timeout=setTimeout(function(){x.slideReset()},300)):x.params.lazyLoading&&x.lazy&&x.lazy.load(),x.emit("onScroll",x,e),x.params.autoplay&&x.params.autoplayDisableOnInteraction&&x.stopAutoplay(),0===r||r===x.maxTranslate())return}else{if((new window.Date).getTime()-x.mousewheel.lastScrollTime>60)if(a<0)if(x.isEnd&&!x.params.loop||x.animating){if(x.params.mousewheelReleaseOnEdges)return!0}else x.slideNext(),x.emit("onScroll",x,e);else if(x.isBeginning&&!x.params.loop||x.animating){if(x.params.mousewheelReleaseOnEdges)return!0}else x.slidePrev(),x.emit("onScroll",x,e);x.mousewheel.lastScrollTime=(new window.Date).getTime()}return e.preventDefault?e.preventDefault():e.returnValue=!1,!1}}function m(a,t){a=e(a);var s,r,i,n=x.rtl?-1:1;s=a.attr("data-swiper-parallax")||"0",r=a.attr("data-swiper-parallax-x"),i=a.attr("data-swiper-parallax-y"),r||i?(r=r||"0",i=i||"0"):x.isHorizontal()?(r=s,i="0"):(i=s,r="0"),r=r.indexOf("%")>=0?parseInt(r,10)*t*n+"%":r*t*n+"px",i=i.indexOf("%")>=0?parseInt(i,10)*t+"%":i*t+"px",a.transform("translate3d("+r+", "+i+",0px)")}function u(e){return 0!==e.indexOf("on")&&(e=e[0]!==e[0].toUpperCase()?"on"+e[0].toUpperCase()+e.substring(1):"on"+e),e}if(!(this instanceof a))return new a(t,s);var c={direction:"horizontal",touchEventsTarget:"container",initialSlide:0,speed:300,autoplay:!1,autoplayDisableOnInteraction:!0,autoplayStopOnLast:!1,iOSEdgeSwipeDetection:!1,iOSEdgeSwipeThreshold:20,freeMode:!1,freeModeMomentum:!0,freeModeMomentumRatio:1,freeModeMomentumBounce:!0,freeModeMomentumBounceRatio:1,freeModeMomentumVelocityRatio:1,freeModeSticky:!1,freeModeMinimumVelocity:.02,autoHeight:!1,setWrapperSize:!1,virtualTranslate:!1,effect:"slide",coverflow:{rotate:50,stretch:0,depth:100,modifier:1,slideShadows:!0},flip:{slideShadows:!0,limitRotation:!0},cube:{slideShadows:!0,shadow:!0,shadowOffset:20,shadowScale:.94},fade:{crossFade:!1},parallax:!1,zoom:!1,zoomMax:3,zoomMin:1,zoomToggle:!0,scrollbar:null,scrollbarHide:!0,scrollbarDraggable:!1,scrollbarSnapOnRelease:!1,keyboardControl:!1,mousewheelControl:!1,mousewheelReleaseOnEdges:!1,mousewheelInvert:!1,mousewheelForceToAxis:!1,mousewheelSensitivity:1,mousewheelEventsTarged:"container",hashnav:!1,hashnavWatchState:!1,history:!1,replaceState:!1,breakpoints:void 0,spaceBetween:0,slidesPerView:1,slidesPerColumn:1,slidesPerColumnFill:"column",slidesPerGroup:1,centeredSlides:!1,slidesOffsetBefore:0,slidesOffsetAfter:0,roundLengths:!1,touchRatio:1,touchAngle:45,simulateTouch:!0,shortSwipes:!0,longSwipes:!0,longSwipesRatio:.5,longSwipesMs:300,followFinger:!0,onlyExternal:!1,threshold:0,touchMoveStopPropagation:!0,touchReleaseOnEdges:!1,uniqueNavElements:!0,pagination:null,paginationElement:"span",paginationClickable:!1,paginationHide:!1,paginationBulletRender:null,paginationProgressRender:null,paginationFractionRender:null,paginationCustomRender:null,paginationType:"bullets",resistance:!0,resistanceRatio:.85,nextButton:null,prevButton:null,watchSlidesProgress:!1,watchSlidesVisibility:!1,grabCursor:!1,preventClicks:!0,preventClicksPropagation:!0,slideToClickedSlide:!1,lazyLoading:!1,lazyLoadingInPrevNext:!1,lazyLoadingInPrevNextAmount:1,lazyLoadingOnTransitionStart:!1,preloadImages:!0,updateOnImagesReady:!0,loop:!1,loopAdditionalSlides:0,loopedSlides:null,control:void 0,controlInverse:!1,controlBy:"slide",normalizeSlideIndex:!0,allowSwipeToPrev:!0,allowSwipeToNext:!0,swipeHandler:null,noSwiping:!0,noSwipingClass:"swiper-no-swiping",passiveListeners:!0,containerModifierClass:"swiper-container-",slideClass:"swiper-slide",slideActiveClass:"swiper-slide-active",slideDuplicateActiveClass:"swiper-slide-duplicate-active",slideVisibleClass:"swiper-slide-visible",slideDuplicateClass:"swiper-slide-duplicate",slideNextClass:"swiper-slide-next",slideDuplicateNextClass:"swiper-slide-duplicate-next",slidePrevClass:"swiper-slide-prev",slideDuplicatePrevClass:"swiper-slide-duplicate-prev",wrapperClass:"swiper-wrapper",bulletClass:"swiper-pagination-bullet",bulletActiveClass:"swiper-pagination-bullet-active",buttonDisabledClass:"swiper-button-disabled",paginationCurrentClass:"swiper-pagination-current",paginationTotalClass:"swiper-pagination-total",paginationHiddenClass:"swiper-pagination-hidden",paginationProgressbarClass:"swiper-pagination-progressbar",paginationClickableClass:"swiper-pagination-clickable",paginationModifierClass:"swiper-pagination-",lazyLoadingClass:"swiper-lazy",lazyStatusLoadingClass:"swiper-lazy-loading",lazyStatusLoadedClass:"swiper-lazy-loaded",lazyPreloaderClass:"swiper-lazy-preloader",notificationClass:"swiper-notification",preloaderClass:"preloader",zoomContainerClass:"swiper-zoom-container",observer:!1,observeParents:!1,a11y:!1,prevSlideMessage:"Previous slide",nextSlideMessage:"Next slide",firstSlideMessage:"This is the first slide",lastSlideMessage:"This is the last slide",paginationBulletMessage:"Go to slide {{index}}",runCallbacksOnInit:!0},g=s&&s.virtualTranslate;s=s||{};var h={};for(var v in s)if("object"!=typeof s[v]||null===s[v]||(s[v].nodeType||s[v]===window||s[v]===document||"undefined"!=typeof Dom7&&s[v]instanceof Dom7||"undefined"!=typeof jQuery&&s[v]instanceof jQuery))h[v]=s[v];else{h[v]={};for(var f in s[v])h[v][f]=s[v][f]}for(var w in c)if(void 0===s[w])s[w]=c[w];else if("object"==typeof s[w])for(var y in c[w])void 0===s[w][y]&&(s[w][y]=c[w][y]);var x=this;if(x.params=s,x.originalParams=h,x.classNames=[],void 0!==e&&"undefined"!=typeof Dom7&&(e=Dom7),(void 0!==e||(e="undefined"==typeof Dom7?window.Dom7||window.Zepto||window.jQuery:Dom7))&&(x.$=e,x.currentBreakpoint=void 0,x.getActiveBreakpoint=function(){if(!x.params.breakpoints)return!1;var e,a=!1,t=[];for(e in x.params.breakpoints)x.params.breakpoints.hasOwnProperty(e)&&t.push(e);t.sort(function(e,a){return parseInt(e,10)>parseInt(a,10)});for(var s=0;s<t.length;s++)(e=t[s])>=window.innerWidth&&!a&&(a=e);return a||"max"},x.setBreakpoint=function(){var e=x.getActiveBreakpoint();if(e&&x.currentBreakpoint!==e){var a=e in x.params.breakpoints?x.params.breakpoints[e]:x.originalParams,t=x.params.loop&&a.slidesPerView!==x.params.slidesPerView;for(var s in a)x.params[s]=a[s];x.currentBreakpoint=e,t&&x.destroyLoop&&x.reLoop(!0)}},x.params.breakpoints&&x.setBreakpoint(),x.container=e(t),0!==x.container.length)){if(x.container.length>1){var T=[];return x.container.each(function(){T.push(new a(this,s))}),T}x.container[0].swiper=x,x.container.data("swiper",x),x.classNames.push(x.params.containerModifierClass+x.params.direction),x.params.freeMode&&x.classNames.push(x.params.containerModifierClass+"free-mode"),x.support.flexbox||(x.classNames.push(x.params.containerModifierClass+"no-flexbox"),x.params.slidesPerColumn=1),x.params.autoHeight&&x.classNames.push(x.params.containerModifierClass+"autoheight"),(x.params.parallax||x.params.watchSlidesVisibility)&&(x.params.watchSlidesProgress=!0),x.params.touchReleaseOnEdges&&(x.params.resistanceRatio=0),["cube","coverflow","flip"].indexOf(x.params.effect)>=0&&(x.support.transforms3d?(x.params.watchSlidesProgress=!0,x.classNames.push(x.params.containerModifierClass+"3d")):x.params.effect="slide"),"slide"!==x.params.effect&&x.classNames.push(x.params.containerModifierClass+x.params.effect),"cube"===x.params.effect&&(x.params.resistanceRatio=0,x.params.slidesPerView=1,x.params.slidesPerColumn=1,x.params.slidesPerGroup=1,x.params.centeredSlides=!1,x.params.spaceBetween=0,x.params.virtualTranslate=!0),"fade"!==x.params.effect&&"flip"!==x.params.effect||(x.params.slidesPerView=1,x.params.slidesPerColumn=1,x.params.slidesPerGroup=1,x.params.watchSlidesProgress=!0,x.params.spaceBetween=0,void 0===g&&(x.params.virtualTranslate=!0)),x.params.grabCursor&&x.support.touch&&(x.params.grabCursor=!1),x.wrapper=x.container.children("."+x.params.wrapperClass),x.params.pagination&&(x.paginationContainer=e(x.params.pagination),x.params.uniqueNavElements&&"string"==typeof x.params.pagination&&x.paginationContainer.length>1&&1===x.container.find(x.params.pagination).length&&(x.paginationContainer=x.container.find(x.params.pagination)),"bullets"===x.params.paginationType&&x.params.paginationClickable?x.paginationContainer.addClass(x.params.paginationModifierClass+"clickable"):x.params.paginationClickable=!1,x.paginationContainer.addClass(x.params.paginationModifierClass+x.params.paginationType)),(x.params.nextButton||x.params.prevButton)&&(x.params.nextButton&&(x.nextButton=e(x.params.nextButton),x.params.uniqueNavElements&&"string"==typeof x.params.nextButton&&x.nextButton.length>1&&1===x.container.find(x.params.nextButton).length&&(x.nextButton=x.container.find(x.params.nextButton))),x.params.prevButton&&(x.prevButton=e(x.params.prevButton),x.params.uniqueNavElements&&"string"==typeof x.params.prevButton&&x.prevButton.length>1&&1===x.container.find(x.params.prevButton).length&&(x.prevButton=x.container.find(x.params.prevButton)))),x.isHorizontal=function(){return"horizontal"===x.params.direction},x.rtl=x.isHorizontal()&&("rtl"===x.container[0].dir.toLowerCase()||"rtl"===x.container.css("direction")),x.rtl&&x.classNames.push(x.params.containerModifierClass+"rtl"),x.rtl&&(x.wrongRTL="-webkit-box"===x.wrapper.css("display")),x.params.slidesPerColumn>1&&x.classNames.push(x.params.containerModifierClass+"multirow"),x.device.android&&x.classNames.push(x.params.containerModifierClass+"android"),x.container.addClass(x.classNames.join(" ")),x.translate=0,x.progress=0,x.velocity=0,x.lockSwipeToNext=function(){x.params.allowSwipeToNext=!1,x.params.allowSwipeToPrev===!1&&x.params.grabCursor&&x.unsetGrabCursor()},x.lockSwipeToPrev=function(){x.params.allowSwipeToPrev=!1,x.params.allowSwipeToNext===!1&&x.params.grabCursor&&x.unsetGrabCursor()},x.lockSwipes=function(){x.params.allowSwipeToNext=x.params.allowSwipeToPrev=!1,x.params.grabCursor&&x.unsetGrabCursor()},x.unlockSwipeToNext=function(){x.params.allowSwipeToNext=!0,x.params.allowSwipeToPrev===!0&&x.params.grabCursor&&x.setGrabCursor()},x.unlockSwipeToPrev=function(){x.params.allowSwipeToPrev=!0,x.params.allowSwipeToNext===!0&&x.params.grabCursor&&x.setGrabCursor()},x.unlockSwipes=function(){x.params.allowSwipeToNext=x.params.allowSwipeToPrev=!0,x.params.grabCursor&&x.setGrabCursor()},x.setGrabCursor=function(e){x.container[0].style.cursor="move",x.container[0].style.cursor=e?"-webkit-grabbing":"-webkit-grab",x.container[0].style.cursor=e?"-moz-grabbin":"-moz-grab",x.container[0].style.cursor=e?"grabbing":"grab"},x.unsetGrabCursor=function(){x.container[0].style.cursor=""},x.params.grabCursor&&x.setGrabCursor(),x.imagesToLoad=[],x.imagesLoaded=0,x.loadImage=function(e,a,t,s,r,i){function n(){i&&i()}var o;e.complete&&r?n():a?(o=new window.Image,o.onload=n,o.onerror=n,s&&(o.sizes=s),t&&(o.srcset=t),a&&(o.src=a)):n()},x.preloadImages=function(){function e(){void 0!==x&&null!==x&&x&&(void 0!==x.imagesLoaded&&x.imagesLoaded++,x.imagesLoaded===x.imagesToLoad.length&&(x.params.updateOnImagesReady&&x.update(),x.emit("onImagesReady",x)))}x.imagesToLoad=x.container.find("img");for(var a=0;a<x.imagesToLoad.length;a++)x.loadImage(x.imagesToLoad[a],x.imagesToLoad[a].currentSrc||x.imagesToLoad[a].getAttribute("src"),x.imagesToLoad[a].srcset||x.imagesToLoad[a].getAttribute("srcset"),x.imagesToLoad[a].sizes||x.imagesToLoad[a].getAttribute("sizes"),!0,e)},x.autoplayTimeoutId=void 0,x.autoplaying=!1,x.autoplayPaused=!1,x.startAutoplay=function(){return void 0===x.autoplayTimeoutId&&(!!x.params.autoplay&&(!x.autoplaying&&(x.autoplaying=!0,x.emit("onAutoplayStart",x),void i())))},x.stopAutoplay=function(e){x.autoplayTimeoutId&&(x.autoplayTimeoutId&&clearTimeout(x.autoplayTimeoutId),x.autoplaying=!1,x.autoplayTimeoutId=void 0,x.emit("onAutoplayStop",x))},x.pauseAutoplay=function(e){x.autoplayPaused||(x.autoplayTimeoutId&&clearTimeout(x.autoplayTimeoutId),x.autoplayPaused=!0,0===e?(x.autoplayPaused=!1,i()):x.wrapper.transitionEnd(function(){x&&(x.autoplayPaused=!1,x.autoplaying?i():x.stopAutoplay())}))},x.minTranslate=function(){return-x.snapGrid[0]},x.maxTranslate=function(){return-x.snapGrid[x.snapGrid.length-1]},x.updateAutoHeight=function(){var e,a=[],t=0;if("auto"!==x.params.slidesPerView&&x.params.slidesPerView>1)for(e=0;e<Math.ceil(x.params.slidesPerView);e++){var s=x.activeIndex+e;if(s>x.slides.length)break;a.push(x.slides.eq(s)[0])}else a.push(x.slides.eq(x.activeIndex)[0]);for(e=0;e<a.length;e++)if(void 0!==a[e]){var r=a[e].offsetHeight;t=r>t?r:t}t&&x.wrapper.css("height",t+"px")},x.updateContainerSize=function(){var e,a;e=void 0!==x.params.width?x.params.width:x.container[0].clientWidth,a=void 0!==x.params.height?x.params.height:x.container[0].clientHeight,0===e&&x.isHorizontal()||0===a&&!x.isHorizontal()||(e=e-parseInt(x.container.css("padding-left"),10)-parseInt(x.container.css("padding-right"),10),a=a-parseInt(x.container.css("padding-top"),10)-parseInt(x.container.css("padding-bottom"),10),x.width=e,x.height=a,x.size=x.isHorizontal()?x.width:x.height)},x.updateSlidesSize=function(){x.slides=x.wrapper.children("."+x.params.slideClass),x.snapGrid=[],x.slidesGrid=[],x.slidesSizesGrid=[];var e,a=x.params.spaceBetween,t=-x.params.slidesOffsetBefore,s=0,i=0;if(void 0!==x.size){"string"==typeof a&&a.indexOf("%")>=0&&(a=parseFloat(a.replace("%",""))/100*x.size),x.virtualSize=-a,x.rtl?x.slides.css({marginLeft:"",marginTop:""}):x.slides.css({marginRight:"",marginBottom:""});var n;x.params.slidesPerColumn>1&&(n=Math.floor(x.slides.length/x.params.slidesPerColumn)===x.slides.length/x.params.slidesPerColumn?x.slides.length:Math.ceil(x.slides.length/x.params.slidesPerColumn)*x.params.slidesPerColumn,"auto"!==x.params.slidesPerView&&"row"===x.params.slidesPerColumnFill&&(n=Math.max(n,x.params.slidesPerView*x.params.slidesPerColumn)));var o,l=x.params.slidesPerColumn,p=n/l,d=p-(x.params.slidesPerColumn*p-x.slides.length);for(e=0;e<x.slides.length;e++){o=0;var m=x.slides.eq(e);if(x.params.slidesPerColumn>1){var u,c,g;"column"===x.params.slidesPerColumnFill?(c=Math.floor(e/l),g=e-c*l,(c>d||c===d&&g===l-1)&&++g>=l&&(g=0,c++),u=c+g*n/l,m.css({"-webkit-box-ordinal-group":u,"-moz-box-ordinal-group":u,"-ms-flex-order":u,"-webkit-order":u,order:u})):(g=Math.floor(e/p),c=e-g*p),m.css("margin-"+(x.isHorizontal()?"top":"left"),0!==g&&x.params.spaceBetween&&x.params.spaceBetween+"px").attr("data-swiper-column",c).attr("data-swiper-row",g)}"none"!==m.css("display")&&("auto"===x.params.slidesPerView?(o=x.isHorizontal()?m.outerWidth(!0):m.outerHeight(!0),x.params.roundLengths&&(o=r(o))):(o=(x.size-(x.params.slidesPerView-1)*a)/x.params.slidesPerView,x.params.roundLengths&&(o=r(o)),x.isHorizontal()?x.slides[e].style.width=o+"px":x.slides[e].style.height=o+"px"),x.slides[e].swiperSlideSize=o,x.slidesSizesGrid.push(o),x.params.centeredSlides?(t=t+o/2+s/2+a,0===s&&0!==e&&(t=t-x.size/2-a),0===e&&(t=t-x.size/2-a),Math.abs(t)<.001&&(t=0),i%x.params.slidesPerGroup==0&&x.snapGrid.push(t),x.slidesGrid.push(t)):(i%x.params.slidesPerGroup==0&&x.snapGrid.push(t),x.slidesGrid.push(t),t=t+o+a),x.virtualSize+=o+a,s=o,i++)}x.virtualSize=Math.max(x.virtualSize,x.size)+x.params.slidesOffsetAfter;var h;if(x.rtl&&x.wrongRTL&&("slide"===x.params.effect||"coverflow"===x.params.effect)&&x.wrapper.css({width:x.virtualSize+x.params.spaceBetween+"px"}),x.support.flexbox&&!x.params.setWrapperSize||(x.isHorizontal()?x.wrapper.css({width:x.virtualSize+x.params.spaceBetween+"px"}):x.wrapper.css({height:x.virtualSize+x.params.spaceBetween+"px"})),x.params.slidesPerColumn>1&&(x.virtualSize=(o+x.params.spaceBetween)*n,x.virtualSize=Math.ceil(x.virtualSize/x.params.slidesPerColumn)-x.params.spaceBetween,x.isHorizontal()?x.wrapper.css({width:x.virtualSize+x.params.spaceBetween+"px"}):x.wrapper.css({height:x.virtualSize+x.params.spaceBetween+"px"}),x.params.centeredSlides)){for(h=[],e=0;e<x.snapGrid.length;e++)x.snapGrid[e]<x.virtualSize+x.snapGrid[0]&&h.push(x.snapGrid[e]);x.snapGrid=h}if(!x.params.centeredSlides){for(h=[],e=0;e<x.snapGrid.length;e++)x.snapGrid[e]<=x.virtualSize-x.size&&h.push(x.snapGrid[e]);x.snapGrid=h,Math.floor(x.virtualSize-x.size)-Math.floor(x.snapGrid[x.snapGrid.length-1])>1&&x.snapGrid.push(x.virtualSize-x.size)}0===x.snapGrid.length&&(x.snapGrid=[0]),0!==x.params.spaceBetween&&(x.isHorizontal()?x.rtl?x.slides.css({marginLeft:a+"px"}):x.slides.css({marginRight:a+"px"}):x.slides.css({marginBottom:a+"px"})),x.params.watchSlidesProgress&&x.updateSlidesOffset()}},x.updateSlidesOffset=function(){for(var e=0;e<x.slides.length;e++)x.slides[e].swiperSlideOffset=x.isHorizontal()?x.slides[e].offsetLeft:x.slides[e].offsetTop},x.currentSlidesPerView=function(){var e,a,t=1;if(x.params.centeredSlides){var s,r=x.slides[x.activeIndex].swiperSlideSize;for(e=x.activeIndex+1;e<x.slides.length;e++)x.slides[e]&&!s&&(r+=x.slides[e].swiperSlideSize,t++,r>x.size&&(s=!0));for(a=x.activeIndex-1;a>=0;a--)x.slides[a]&&!s&&(r+=x.slides[a].swiperSlideSize,t++,r>x.size&&(s=!0))}else for(e=x.activeIndex+1;e<x.slides.length;e++)x.slidesGrid[e]-x.slidesGrid[x.activeIndex]<x.size&&t++;return t},x.updateSlidesProgress=function(e){if(void 0===e&&(e=x.translate||0),0!==x.slides.length){void 0===x.slides[0].swiperSlideOffset&&x.updateSlidesOffset();var a=-e;x.rtl&&(a=e),x.slides.removeClass(x.params.slideVisibleClass);for(var t=0;t<x.slides.length;t++){var s=x.slides[t],r=(a+(x.params.centeredSlides?x.minTranslate():0)-s.swiperSlideOffset)/(s.swiperSlideSize+x.params.spaceBetween);if(x.params.watchSlidesVisibility){var i=-(a-s.swiperSlideOffset),n=i+x.slidesSizesGrid[t];(i>=0&&i<x.size||n>0&&n<=x.size||i<=0&&n>=x.size)&&x.slides.eq(t).addClass(x.params.slideVisibleClass)}s.progress=x.rtl?-r:r}}},x.updateProgress=function(e){void 0===e&&(e=x.translate||0);var a=x.maxTranslate()-x.minTranslate(),t=x.isBeginning,s=x.isEnd;0===a?(x.progress=0,x.isBeginning=x.isEnd=!0):(x.progress=(e-x.minTranslate())/a,x.isBeginning=x.progress<=0,x.isEnd=x.progress>=1),x.isBeginning&&!t&&x.emit("onReachBeginning",x),x.isEnd&&!s&&x.emit("onReachEnd",x),x.params.watchSlidesProgress&&x.updateSlidesProgress(e),x.emit("onProgress",x,x.progress)},x.updateActiveIndex=function(){var e,a,t,s=x.rtl?x.translate:-x.translate;for(a=0;a<x.slidesGrid.length;a++)void 0!==x.slidesGrid[a+1]?s>=x.slidesGrid[a]&&s<x.slidesGrid[a+1]-(x.slidesGrid[a+1]-x.slidesGrid[a])/2?e=a:s>=x.slidesGrid[a]&&s<x.slidesGrid[a+1]&&(e=a+1):s>=x.slidesGrid[a]&&(e=a);x.params.normalizeSlideIndex&&(e<0||void 0===e)&&(e=0),t=Math.floor(e/x.params.slidesPerGroup),t>=x.snapGrid.length&&(t=x.snapGrid.length-1),e!==x.activeIndex&&(x.snapIndex=t,x.previousIndex=x.activeIndex,x.activeIndex=e,x.updateClasses(),x.updateRealIndex())},x.updateRealIndex=function(){x.realIndex=parseInt(x.slides.eq(x.activeIndex).attr("data-swiper-slide-index")||x.activeIndex,10)},x.updateClasses=function(){x.slides.removeClass(x.params.slideActiveClass+" "+x.params.slideNextClass+" "+x.params.slidePrevClass+" "+x.params.slideDuplicateActiveClass+" "+x.params.slideDuplicateNextClass+" "+x.params.slideDuplicatePrevClass);var a=x.slides.eq(x.activeIndex);a.addClass(x.params.slideActiveClass),s.loop&&(a.hasClass(x.params.slideDuplicateClass)?x.wrapper.children("."+x.params.slideClass+":not(."+x.params.slideDuplicateClass+')[data-swiper-slide-index="'+x.realIndex+'"]').addClass(x.params.slideDuplicateActiveClass):x.wrapper.children("."+x.params.slideClass+"."+x.params.slideDuplicateClass+'[data-swiper-slide-index="'+x.realIndex+'"]').addClass(x.params.slideDuplicateActiveClass));var t=a.next("."+x.params.slideClass).addClass(x.params.slideNextClass);x.params.loop&&0===t.length&&(t=x.slides.eq(0),t.addClass(x.params.slideNextClass));var r=a.prev("."+x.params.slideClass).addClass(x.params.slidePrevClass);if(x.params.loop&&0===r.length&&(r=x.slides.eq(-1),r.addClass(x.params.slidePrevClass)),s.loop&&(t.hasClass(x.params.slideDuplicateClass)?x.wrapper.children("."+x.params.slideClass+":not(."+x.params.slideDuplicateClass+')[data-swiper-slide-index="'+t.attr("data-swiper-slide-index")+'"]').addClass(x.params.slideDuplicateNextClass):x.wrapper.children("."+x.params.slideClass+"."+x.params.slideDuplicateClass+'[data-swiper-slide-index="'+t.attr("data-swiper-slide-index")+'"]').addClass(x.params.slideDuplicateNextClass),r.hasClass(x.params.slideDuplicateClass)?x.wrapper.children("."+x.params.slideClass+":not(."+x.params.slideDuplicateClass+')[data-swiper-slide-index="'+r.attr("data-swiper-slide-index")+'"]').addClass(x.params.slideDuplicatePrevClass):x.wrapper.children("."+x.params.slideClass+"."+x.params.slideDuplicateClass+'[data-swiper-slide-index="'+r.attr("data-swiper-slide-index")+'"]').addClass(x.params.slideDuplicatePrevClass)),x.paginationContainer&&x.paginationContainer.length>0){var i,n=x.params.loop?Math.ceil((x.slides.length-2*x.loopedSlides)/x.params.slidesPerGroup):x.snapGrid.length;if(x.params.loop?(i=Math.ceil((x.activeIndex-x.loopedSlides)/x.params.slidesPerGroup),i>x.slides.length-1-2*x.loopedSlides&&(i-=x.slides.length-2*x.loopedSlides),i>n-1&&(i-=n),i<0&&"bullets"!==x.params.paginationType&&(i=n+i)):i=void 0!==x.snapIndex?x.snapIndex:x.activeIndex||0,"bullets"===x.params.paginationType&&x.bullets&&x.bullets.length>0&&(x.bullets.removeClass(x.params.bulletActiveClass),x.paginationContainer.length>1?x.bullets.each(function(){e(this).index()===i&&e(this).addClass(x.params.bulletActiveClass)}):x.bullets.eq(i).addClass(x.params.bulletActiveClass)),"fraction"===x.params.paginationType&&(x.paginationContainer.find("."+x.params.paginationCurrentClass).text(i+1),x.paginationContainer.find("."+x.params.paginationTotalClass).text(n)),"progress"===x.params.paginationType){var o=(i+1)/n,l=o,p=1;x.isHorizontal()||(p=o,l=1),x.paginationContainer.find("."+x.params.paginationProgressbarClass).transform("translate3d(0,0,0) scaleX("+l+") scaleY("+p+")").transition(x.params.speed)}"custom"===x.params.paginationType&&x.params.paginationCustomRender&&(x.paginationContainer.html(x.params.paginationCustomRender(x,i+1,n)),x.emit("onPaginationRendered",x,x.paginationContainer[0]))}x.params.loop||(x.params.prevButton&&x.prevButton&&x.prevButton.length>0&&(x.isBeginning?(x.prevButton.addClass(x.params.buttonDisabledClass),x.params.a11y&&x.a11y&&x.a11y.disable(x.prevButton)):(x.prevButton.removeClass(x.params.buttonDisabledClass),x.params.a11y&&x.a11y&&x.a11y.enable(x.prevButton))),x.params.nextButton&&x.nextButton&&x.nextButton.length>0&&(x.isEnd?(x.nextButton.addClass(x.params.buttonDisabledClass),x.params.a11y&&x.a11y&&x.a11y.disable(x.nextButton)):(x.nextButton.removeClass(x.params.buttonDisabledClass),x.params.a11y&&x.a11y&&x.a11y.enable(x.nextButton))))},x.updatePagination=function(){if(x.params.pagination&&x.paginationContainer&&x.paginationContainer.length>0){var e="";if("bullets"===x.params.paginationType){for(var a=x.params.loop?Math.ceil((x.slides.length-2*x.loopedSlides)/x.params.slidesPerGroup):x.snapGrid.length,t=0;t<a;t++)e+=x.params.paginationBulletRender?x.params.paginationBulletRender(x,t,x.params.bulletClass):"<"+x.params.paginationElement+' class="'+x.params.bulletClass+'"></'+x.params.paginationElement+">";x.paginationContainer.html(e),x.bullets=x.paginationContainer.find("."+x.params.bulletClass),x.params.paginationClickable&&x.params.a11y&&x.a11y&&x.a11y.initPagination()}"fraction"===x.params.paginationType&&(e=x.params.paginationFractionRender?x.params.paginationFractionRender(x,x.params.paginationCurrentClass,x.params.paginationTotalClass):'<span class="'+x.params.paginationCurrentClass+'"></span> / <span class="'+x.params.paginationTotalClass+'"></span>',x.paginationContainer.html(e)),"progress"===x.params.paginationType&&(e=x.params.paginationProgressRender?x.params.paginationProgressRender(x,x.params.paginationProgressbarClass):'<span class="'+x.params.paginationProgressbarClass+'"></span>',x.paginationContainer.html(e)),"custom"!==x.params.paginationType&&x.emit("onPaginationRendered",x,x.paginationContainer[0])}},x.update=function(e){function a(){x.rtl,x.translate;t=Math.min(Math.max(x.translate,x.maxTranslate()),x.minTranslate()),x.setWrapperTranslate(t),x.updateActiveIndex(),x.updateClasses()}if(x){x.updateContainerSize(),x.updateSlidesSize(),x.updateProgress(),x.updatePagination(),x.updateClasses(),x.params.scrollbar&&x.scrollbar&&x.scrollbar.set();var t;if(e){x.controller&&x.controller.spline&&(x.controller.spline=void 0),x.params.freeMode?(a(),x.params.autoHeight&&x.updateAutoHeight()):(("auto"===x.params.slidesPerView||x.params.slidesPerView>1)&&x.isEnd&&!x.params.centeredSlides?x.slideTo(x.slides.length-1,0,!1,!0):x.slideTo(x.activeIndex,0,!1,!0))||a()}else x.params.autoHeight&&x.updateAutoHeight()}},x.onResize=function(e){x.params.onBeforeResize&&x.params.onBeforeResize(x),x.params.breakpoints&&x.setBreakpoint();var a=x.params.allowSwipeToPrev,t=x.params.allowSwipeToNext;x.params.allowSwipeToPrev=x.params.allowSwipeToNext=!0,x.updateContainerSize(),x.updateSlidesSize(),("auto"===x.params.slidesPerView||x.params.freeMode||e)&&x.updatePagination(),x.params.scrollbar&&x.scrollbar&&x.scrollbar.set(),x.controller&&x.controller.spline&&(x.controller.spline=void 0);var s=!1;if(x.params.freeMode){var r=Math.min(Math.max(x.translate,x.maxTranslate()),x.minTranslate());x.setWrapperTranslate(r),x.updateActiveIndex(),x.updateClasses(),x.params.autoHeight&&x.updateAutoHeight()}else x.updateClasses(),s=("auto"===x.params.slidesPerView||x.params.slidesPerView>1)&&x.isEnd&&!x.params.centeredSlides?x.slideTo(x.slides.length-1,0,!1,!0):x.slideTo(x.activeIndex,0,!1,!0);x.params.lazyLoading&&!s&&x.lazy&&x.lazy.load(),x.params.allowSwipeToPrev=a,x.params.allowSwipeToNext=t,x.params.onAfterResize&&x.params.onAfterResize(x)},x.touchEventsDesktop={start:"mousedown",move:"mousemove",end:"mouseup"},window.navigator.pointerEnabled?x.touchEventsDesktop={start:"pointerdown",move:"pointermove",end:"pointerup"}:window.navigator.msPointerEnabled&&(x.touchEventsDesktop={start:"MSPointerDown",move:"MSPointerMove",end:"MSPointerUp"}),x.touchEvents={start:x.support.touch||!x.params.simulateTouch?"touchstart":x.touchEventsDesktop.start,move:x.support.touch||!x.params.simulateTouch?"touchmove":x.touchEventsDesktop.move,end:x.support.touch||!x.params.simulateTouch?"touchend":x.touchEventsDesktop.end},(window.navigator.pointerEnabled||window.navigator.msPointerEnabled)&&("container"===x.params.touchEventsTarget?x.container:x.wrapper).addClass("swiper-wp8-"+x.params.direction),x.initEvents=function(e){var a=e?"off":"on",t=e?"removeEventListener":"addEventListener",r="container"===x.params.touchEventsTarget?x.container[0]:x.wrapper[0],i=x.support.touch?r:document,n=!!x.params.nested;if(x.browser.ie)r[t](x.touchEvents.start,x.onTouchStart,!1),i[t](x.touchEvents.move,x.onTouchMove,n),i[t](x.touchEvents.end,x.onTouchEnd,!1);else{if(x.support.touch){var o=!("touchstart"!==x.touchEvents.start||!x.support.passiveListener||!x.params.passiveListeners)&&{passive:!0,capture:!1};r[t](x.touchEvents.start,x.onTouchStart,o),r[t](x.touchEvents.move,x.onTouchMove,n),r[t](x.touchEvents.end,x.onTouchEnd,o)}(s.simulateTouch&&!x.device.ios&&!x.device.android||s.simulateTouch&&!x.support.touch&&x.device.ios)&&(r[t]("mousedown",x.onTouchStart,!1),document[t]("mousemove",x.onTouchMove,n),document[t]("mouseup",x.onTouchEnd,!1))}window[t]("resize",x.onResize),x.params.nextButton&&x.nextButton&&x.nextButton.length>0&&(x.nextButton[a]("click",x.onClickNext),x.params.a11y&&x.a11y&&x.nextButton[a]("keydown",x.a11y.onEnterKey)),x.params.prevButton&&x.prevButton&&x.prevButton.length>0&&(x.prevButton[a]("click",x.onClickPrev),x.params.a11y&&x.a11y&&x.prevButton[a]("keydown",x.a11y.onEnterKey)),x.params.pagination&&x.params.paginationClickable&&(x.paginationContainer[a]("click","."+x.params.bulletClass,x.onClickIndex),x.params.a11y&&x.a11y&&x.paginationContainer[a]("keydown","."+x.params.bulletClass,x.a11y.onEnterKey)),(x.params.preventClicks||x.params.preventClicksPropagation)&&r[t]("click",x.preventClicks,!0)},x.attachEvents=function(){x.initEvents()},x.detachEvents=function(){x.initEvents(!0)},x.allowClick=!0,x.preventClicks=function(e){x.allowClick||(x.params.preventClicks&&e.preventDefault(),x.params.preventClicksPropagation&&x.animating&&(e.stopPropagation(),e.stopImmediatePropagation()))},x.onClickNext=function(e){e.preventDefault(),x.isEnd&&!x.params.loop||x.slideNext()},x.onClickPrev=function(e){e.preventDefault(),x.isBeginning&&!x.params.loop||x.slidePrev()},x.onClickIndex=function(a){a.preventDefault();var t=e(this).index()*x.params.slidesPerGroup
;x.params.loop&&(t+=x.loopedSlides),x.slideTo(t)},x.updateClickedSlide=function(a){var t=n(a,"."+x.params.slideClass),s=!1;if(t)for(var r=0;r<x.slides.length;r++)x.slides[r]===t&&(s=!0);if(!t||!s)return x.clickedSlide=void 0,void(x.clickedIndex=void 0);if(x.clickedSlide=t,x.clickedIndex=e(t).index(),x.params.slideToClickedSlide&&void 0!==x.clickedIndex&&x.clickedIndex!==x.activeIndex){var i,o=x.clickedIndex,l="auto"===x.params.slidesPerView?x.currentSlidesPerView():x.params.slidesPerView;if(x.params.loop){if(x.animating)return;i=parseInt(e(x.clickedSlide).attr("data-swiper-slide-index"),10),x.params.centeredSlides?o<x.loopedSlides-l/2||o>x.slides.length-x.loopedSlides+l/2?(x.fixLoop(),o=x.wrapper.children("."+x.params.slideClass+'[data-swiper-slide-index="'+i+'"]:not(.'+x.params.slideDuplicateClass+")").eq(0).index(),setTimeout(function(){x.slideTo(o)},0)):x.slideTo(o):o>x.slides.length-l?(x.fixLoop(),o=x.wrapper.children("."+x.params.slideClass+'[data-swiper-slide-index="'+i+'"]:not(.'+x.params.slideDuplicateClass+")").eq(0).index(),setTimeout(function(){x.slideTo(o)},0)):x.slideTo(o)}else x.slideTo(o)}};var b,C,S,z,M,P,E,I,k,D,L="input, select, textarea, button, video",B=Date.now(),H=[];x.animating=!1,x.touches={startX:0,startY:0,currentX:0,currentY:0,diff:0};var G,X;x.onTouchStart=function(a){if(a.originalEvent&&(a=a.originalEvent),(G="touchstart"===a.type)||!("which"in a)||3!==a.which){if(x.params.noSwiping&&n(a,"."+x.params.noSwipingClass))return void(x.allowClick=!0);if(!x.params.swipeHandler||n(a,x.params.swipeHandler)){var t=x.touches.currentX="touchstart"===a.type?a.targetTouches[0].pageX:a.pageX,s=x.touches.currentY="touchstart"===a.type?a.targetTouches[0].pageY:a.pageY;if(!(x.device.ios&&x.params.iOSEdgeSwipeDetection&&t<=x.params.iOSEdgeSwipeThreshold)){if(b=!0,C=!1,S=!0,M=void 0,X=void 0,x.touches.startX=t,x.touches.startY=s,z=Date.now(),x.allowClick=!0,x.updateContainerSize(),x.swipeDirection=void 0,x.params.threshold>0&&(I=!1),"touchstart"!==a.type){var r=!0;e(a.target).is(L)&&(r=!1),document.activeElement&&e(document.activeElement).is(L)&&document.activeElement.blur(),r&&a.preventDefault()}x.emit("onTouchStart",x,a)}}}},x.onTouchMove=function(a){if(a.originalEvent&&(a=a.originalEvent),!G||"mousemove"!==a.type){if(a.preventedByNestedSwiper)return x.touches.startX="touchmove"===a.type?a.targetTouches[0].pageX:a.pageX,void(x.touches.startY="touchmove"===a.type?a.targetTouches[0].pageY:a.pageY);if(x.params.onlyExternal)return x.allowClick=!1,void(b&&(x.touches.startX=x.touches.currentX="touchmove"===a.type?a.targetTouches[0].pageX:a.pageX,x.touches.startY=x.touches.currentY="touchmove"===a.type?a.targetTouches[0].pageY:a.pageY,z=Date.now()));if(G&&x.params.touchReleaseOnEdges&&!x.params.loop)if(x.isHorizontal()){if(x.touches.currentX<x.touches.startX&&x.translate<=x.maxTranslate()||x.touches.currentX>x.touches.startX&&x.translate>=x.minTranslate())return}else if(x.touches.currentY<x.touches.startY&&x.translate<=x.maxTranslate()||x.touches.currentY>x.touches.startY&&x.translate>=x.minTranslate())return;if(G&&document.activeElement&&a.target===document.activeElement&&e(a.target).is(L))return C=!0,void(x.allowClick=!1);if(S&&x.emit("onTouchMove",x,a),!(a.targetTouches&&a.targetTouches.length>1)){if(x.touches.currentX="touchmove"===a.type?a.targetTouches[0].pageX:a.pageX,x.touches.currentY="touchmove"===a.type?a.targetTouches[0].pageY:a.pageY,void 0===M){var t;x.isHorizontal()&&x.touches.currentY===x.touches.startY||!x.isHorizontal()&&x.touches.currentX===x.touches.startX?M=!1:(t=180*Math.atan2(Math.abs(x.touches.currentY-x.touches.startY),Math.abs(x.touches.currentX-x.touches.startX))/Math.PI,M=x.isHorizontal()?t>x.params.touchAngle:90-t>x.params.touchAngle)}if(M&&x.emit("onTouchMoveOpposite",x,a),void 0===X&&(x.touches.currentX===x.touches.startX&&x.touches.currentY===x.touches.startY||(X=!0)),b){if(M)return void(b=!1);if(X){x.allowClick=!1,x.emit("onSliderMove",x,a),a.preventDefault(),x.params.touchMoveStopPropagation&&!x.params.nested&&a.stopPropagation(),C||(s.loop&&x.fixLoop(),E=x.getWrapperTranslate(),x.setWrapperTransition(0),x.animating&&x.wrapper.trigger("webkitTransitionEnd transitionend oTransitionEnd MSTransitionEnd msTransitionEnd"),x.params.autoplay&&x.autoplaying&&(x.params.autoplayDisableOnInteraction?x.stopAutoplay():x.pauseAutoplay()),D=!1,!x.params.grabCursor||x.params.allowSwipeToNext!==!0&&x.params.allowSwipeToPrev!==!0||x.setGrabCursor(!0)),C=!0;var r=x.touches.diff=x.isHorizontal()?x.touches.currentX-x.touches.startX:x.touches.currentY-x.touches.startY;r*=x.params.touchRatio,x.rtl&&(r=-r),x.swipeDirection=r>0?"prev":"next",P=r+E;var i=!0;if(r>0&&P>x.minTranslate()?(i=!1,x.params.resistance&&(P=x.minTranslate()-1+Math.pow(-x.minTranslate()+E+r,x.params.resistanceRatio))):r<0&&P<x.maxTranslate()&&(i=!1,x.params.resistance&&(P=x.maxTranslate()+1-Math.pow(x.maxTranslate()-E-r,x.params.resistanceRatio))),i&&(a.preventedByNestedSwiper=!0),!x.params.allowSwipeToNext&&"next"===x.swipeDirection&&P<E&&(P=E),!x.params.allowSwipeToPrev&&"prev"===x.swipeDirection&&P>E&&(P=E),x.params.threshold>0){if(!(Math.abs(r)>x.params.threshold||I))return void(P=E);if(!I)return I=!0,x.touches.startX=x.touches.currentX,x.touches.startY=x.touches.currentY,P=E,void(x.touches.diff=x.isHorizontal()?x.touches.currentX-x.touches.startX:x.touches.currentY-x.touches.startY)}x.params.followFinger&&((x.params.freeMode||x.params.watchSlidesProgress)&&x.updateActiveIndex(),x.params.freeMode&&(0===H.length&&H.push({position:x.touches[x.isHorizontal()?"startX":"startY"],time:z}),H.push({position:x.touches[x.isHorizontal()?"currentX":"currentY"],time:(new window.Date).getTime()})),x.updateProgress(P),x.setWrapperTranslate(P))}}}}},x.onTouchEnd=function(a){if(a.originalEvent&&(a=a.originalEvent),S&&x.emit("onTouchEnd",x,a),S=!1,b){x.params.grabCursor&&C&&b&&(x.params.allowSwipeToNext===!0||x.params.allowSwipeToPrev===!0)&&x.setGrabCursor(!1);var t=Date.now(),s=t-z;if(x.allowClick&&(x.updateClickedSlide(a),x.emit("onTap",x,a),s<300&&t-B>300&&(k&&clearTimeout(k),k=setTimeout(function(){x&&(x.params.paginationHide&&x.paginationContainer.length>0&&!e(a.target).hasClass(x.params.bulletClass)&&x.paginationContainer.toggleClass(x.params.paginationHiddenClass),x.emit("onClick",x,a))},300)),s<300&&t-B<300&&(k&&clearTimeout(k),x.emit("onDoubleTap",x,a))),B=Date.now(),setTimeout(function(){x&&(x.allowClick=!0)},0),!b||!C||!x.swipeDirection||0===x.touches.diff||P===E)return void(b=C=!1);b=C=!1;var r;if(r=x.params.followFinger?x.rtl?x.translate:-x.translate:-P,x.params.freeMode){if(r<-x.minTranslate())return void x.slideTo(x.activeIndex);if(r>-x.maxTranslate())return void(x.slides.length<x.snapGrid.length?x.slideTo(x.snapGrid.length-1):x.slideTo(x.slides.length-1));if(x.params.freeModeMomentum){if(H.length>1){var i=H.pop(),n=H.pop(),o=i.position-n.position,l=i.time-n.time;x.velocity=o/l,x.velocity=x.velocity/2,Math.abs(x.velocity)<x.params.freeModeMinimumVelocity&&(x.velocity=0),(l>150||(new window.Date).getTime()-i.time>300)&&(x.velocity=0)}else x.velocity=0;x.velocity=x.velocity*x.params.freeModeMomentumVelocityRatio,H.length=0;var p=1e3*x.params.freeModeMomentumRatio,d=x.velocity*p,m=x.translate+d;x.rtl&&(m=-m);var u,c=!1,g=20*Math.abs(x.velocity)*x.params.freeModeMomentumBounceRatio;if(m<x.maxTranslate())x.params.freeModeMomentumBounce?(m+x.maxTranslate()<-g&&(m=x.maxTranslate()-g),u=x.maxTranslate(),c=!0,D=!0):m=x.maxTranslate();else if(m>x.minTranslate())x.params.freeModeMomentumBounce?(m-x.minTranslate()>g&&(m=x.minTranslate()+g),u=x.minTranslate(),c=!0,D=!0):m=x.minTranslate();else if(x.params.freeModeSticky){var h,v=0;for(v=0;v<x.snapGrid.length;v+=1)if(x.snapGrid[v]>-m){h=v;break}m=Math.abs(x.snapGrid[h]-m)<Math.abs(x.snapGrid[h-1]-m)||"next"===x.swipeDirection?x.snapGrid[h]:x.snapGrid[h-1],x.rtl||(m=-m)}if(0!==x.velocity)p=x.rtl?Math.abs((-m-x.translate)/x.velocity):Math.abs((m-x.translate)/x.velocity);else if(x.params.freeModeSticky)return void x.slideReset();x.params.freeModeMomentumBounce&&c?(x.updateProgress(u),x.setWrapperTransition(p),x.setWrapperTranslate(m),x.onTransitionStart(),x.animating=!0,x.wrapper.transitionEnd(function(){x&&D&&(x.emit("onMomentumBounce",x),x.setWrapperTransition(x.params.speed),x.setWrapperTranslate(u),x.wrapper.transitionEnd(function(){x&&x.onTransitionEnd()}))})):x.velocity?(x.updateProgress(m),x.setWrapperTransition(p),x.setWrapperTranslate(m),x.onTransitionStart(),x.animating||(x.animating=!0,x.wrapper.transitionEnd(function(){x&&x.onTransitionEnd()}))):x.updateProgress(m),x.updateActiveIndex()}return void((!x.params.freeModeMomentum||s>=x.params.longSwipesMs)&&(x.updateProgress(),x.updateActiveIndex()))}var f,w=0,y=x.slidesSizesGrid[0];for(f=0;f<x.slidesGrid.length;f+=x.params.slidesPerGroup)void 0!==x.slidesGrid[f+x.params.slidesPerGroup]?r>=x.slidesGrid[f]&&r<x.slidesGrid[f+x.params.slidesPerGroup]&&(w=f,y=x.slidesGrid[f+x.params.slidesPerGroup]-x.slidesGrid[f]):r>=x.slidesGrid[f]&&(w=f,y=x.slidesGrid[x.slidesGrid.length-1]-x.slidesGrid[x.slidesGrid.length-2]);var T=(r-x.slidesGrid[w])/y;if(s>x.params.longSwipesMs){if(!x.params.longSwipes)return void x.slideTo(x.activeIndex);"next"===x.swipeDirection&&(T>=x.params.longSwipesRatio?x.slideTo(w+x.params.slidesPerGroup):x.slideTo(w)),"prev"===x.swipeDirection&&(T>1-x.params.longSwipesRatio?x.slideTo(w+x.params.slidesPerGroup):x.slideTo(w))}else{if(!x.params.shortSwipes)return void x.slideTo(x.activeIndex);"next"===x.swipeDirection&&x.slideTo(w+x.params.slidesPerGroup),"prev"===x.swipeDirection&&x.slideTo(w)}}},x._slideTo=function(e,a){return x.slideTo(e,a,!0,!0)},x.slideTo=function(e,a,t,s){void 0===t&&(t=!0),void 0===e&&(e=0),e<0&&(e=0),x.snapIndex=Math.floor(e/x.params.slidesPerGroup),x.snapIndex>=x.snapGrid.length&&(x.snapIndex=x.snapGrid.length-1);var r=-x.snapGrid[x.snapIndex];if(x.params.autoplay&&x.autoplaying&&(s||!x.params.autoplayDisableOnInteraction?x.pauseAutoplay(a):x.stopAutoplay()),x.updateProgress(r),x.params.normalizeSlideIndex)for(var i=0;i<x.slidesGrid.length;i++)-Math.floor(100*r)>=Math.floor(100*x.slidesGrid[i])&&(e=i);return!(!x.params.allowSwipeToNext&&r<x.translate&&r<x.minTranslate())&&(!(!x.params.allowSwipeToPrev&&r>x.translate&&r>x.maxTranslate()&&(x.activeIndex||0)!==e)&&(void 0===a&&(a=x.params.speed),x.previousIndex=x.activeIndex||0,x.activeIndex=e,x.updateRealIndex(),x.rtl&&-r===x.translate||!x.rtl&&r===x.translate?(x.params.autoHeight&&x.updateAutoHeight(),x.updateClasses(),"slide"!==x.params.effect&&x.setWrapperTranslate(r),!1):(x.updateClasses(),x.onTransitionStart(t),0===a||x.browser.lteIE9?(x.setWrapperTranslate(r),x.setWrapperTransition(0),x.onTransitionEnd(t)):(x.setWrapperTranslate(r),x.setWrapperTransition(a),x.animating||(x.animating=!0,x.wrapper.transitionEnd(function(){x&&x.onTransitionEnd(t)}))),!0)))},x.onTransitionStart=function(e){void 0===e&&(e=!0),x.params.autoHeight&&x.updateAutoHeight(),x.lazy&&x.lazy.onTransitionStart(),e&&(x.emit("onTransitionStart",x),x.activeIndex!==x.previousIndex&&(x.emit("onSlideChangeStart",x),x.activeIndex>x.previousIndex?x.emit("onSlideNextStart",x):x.emit("onSlidePrevStart",x)))},x.onTransitionEnd=function(e){x.animating=!1,x.setWrapperTransition(0),void 0===e&&(e=!0),x.lazy&&x.lazy.onTransitionEnd(),e&&(x.emit("onTransitionEnd",x),x.activeIndex!==x.previousIndex&&(x.emit("onSlideChangeEnd",x),x.activeIndex>x.previousIndex?x.emit("onSlideNextEnd",x):x.emit("onSlidePrevEnd",x))),x.params.history&&x.history&&x.history.setHistory(x.params.history,x.activeIndex),x.params.hashnav&&x.hashnav&&x.hashnav.setHash()},x.slideNext=function(e,a,t){if(x.params.loop){if(x.animating)return!1;x.fixLoop();x.container[0].clientLeft;return x.slideTo(x.activeIndex+x.params.slidesPerGroup,a,e,t)}return x.slideTo(x.activeIndex+x.params.slidesPerGroup,a,e,t)},x._slideNext=function(e){return x.slideNext(!0,e,!0)},x.slidePrev=function(e,a,t){if(x.params.loop){if(x.animating)return!1;x.fixLoop();x.container[0].clientLeft;return x.slideTo(x.activeIndex-1,a,e,t)}return x.slideTo(x.activeIndex-1,a,e,t)},x._slidePrev=function(e){return x.slidePrev(!0,e,!0)},x.slideReset=function(e,a,t){return x.slideTo(x.activeIndex,a,e)},x.disableTouchControl=function(){return x.params.onlyExternal=!0,!0},x.enableTouchControl=function(){return x.params.onlyExternal=!1,!0},x.setWrapperTransition=function(e,a){x.wrapper.transition(e),"slide"!==x.params.effect&&x.effects[x.params.effect]&&x.effects[x.params.effect].setTransition(e),x.params.parallax&&x.parallax&&x.parallax.setTransition(e),x.params.scrollbar&&x.scrollbar&&x.scrollbar.setTransition(e),x.params.control&&x.controller&&x.controller.setTransition(e,a),x.emit("onSetTransition",x,e)},x.setWrapperTranslate=function(e,a,t){var s=0,i=0;x.isHorizontal()?s=x.rtl?-e:e:i=e,x.params.roundLengths&&(s=r(s),i=r(i)),x.params.virtualTranslate||(x.support.transforms3d?x.wrapper.transform("translate3d("+s+"px, "+i+"px, 0px)"):x.wrapper.transform("translate("+s+"px, "+i+"px)")),x.translate=x.isHorizontal()?s:i;var n,o=x.maxTranslate()-x.minTranslate();n=0===o?0:(e-x.minTranslate())/o,n!==x.progress&&x.updateProgress(e),a&&x.updateActiveIndex(),"slide"!==x.params.effect&&x.effects[x.params.effect]&&x.effects[x.params.effect].setTranslate(x.translate),x.params.parallax&&x.parallax&&x.parallax.setTranslate(x.translate),x.params.scrollbar&&x.scrollbar&&x.scrollbar.setTranslate(x.translate),x.params.control&&x.controller&&x.controller.setTranslate(x.translate,t),x.emit("onSetTranslate",x,x.translate)},x.getTranslate=function(e,a){var t,s,r,i;return void 0===a&&(a="x"),x.params.virtualTranslate?x.rtl?-x.translate:x.translate:(r=window.getComputedStyle(e,null),window.WebKitCSSMatrix?(s=r.transform||r.webkitTransform,s.split(",").length>6&&(s=s.split(", ").map(function(e){return e.replace(",",".")}).join(", ")),i=new window.WebKitCSSMatrix("none"===s?"":s)):(i=r.MozTransform||r.OTransform||r.MsTransform||r.msTransform||r.transform||r.getPropertyValue("transform").replace("translate(","matrix(1, 0, 0, 1,"),t=i.toString().split(",")),"x"===a&&(s=window.WebKitCSSMatrix?i.m41:16===t.length?parseFloat(t[12]):parseFloat(t[4])),"y"===a&&(s=window.WebKitCSSMatrix?i.m42:16===t.length?parseFloat(t[13]):parseFloat(t[5])),x.rtl&&s&&(s=-s),s||0)},x.getWrapperTranslate=function(e){return void 0===e&&(e=x.isHorizontal()?"x":"y"),x.getTranslate(x.wrapper[0],e)},x.observers=[],x.initObservers=function(){if(x.params.observeParents)for(var e=x.container.parents(),a=0;a<e.length;a++)o(e[a]);o(x.container[0],{childList:!1}),o(x.wrapper[0],{attributes:!1})},x.disconnectObservers=function(){for(var e=0;e<x.observers.length;e++)x.observers[e].disconnect();x.observers=[]},x.createLoop=function(){x.wrapper.children("."+x.params.slideClass+"."+x.params.slideDuplicateClass).remove();var a=x.wrapper.children("."+x.params.slideClass);"auto"!==x.params.slidesPerView||x.params.loopedSlides||(x.params.loopedSlides=a.length),x.loopedSlides=parseInt(x.params.loopedSlides||x.params.slidesPerView,10),x.loopedSlides=x.loopedSlides+x.params.loopAdditionalSlides,x.loopedSlides>a.length&&(x.loopedSlides=a.length);var t,s=[],r=[];for(a.each(function(t,i){var n=e(this);t<x.loopedSlides&&r.push(i),t<a.length&&t>=a.length-x.loopedSlides&&s.push(i),n.attr("data-swiper-slide-index",t)}),t=0;t<r.length;t++)x.wrapper.append(e(r[t].cloneNode(!0)).addClass(x.params.slideDuplicateClass));for(t=s.length-1;t>=0;t--)x.wrapper.prepend(e(s[t].cloneNode(!0)).addClass(x.params.slideDuplicateClass))},x.destroyLoop=function(){x.wrapper.children("."+x.params.slideClass+"."+x.params.slideDuplicateClass).remove(),x.slides.removeAttr("data-swiper-slide-index")},x.reLoop=function(e){var a=x.activeIndex-x.loopedSlides;x.destroyLoop(),x.createLoop(),x.updateSlidesSize(),e&&x.slideTo(a+x.loopedSlides,0,!1)},x.fixLoop=function(){var e;x.activeIndex<x.loopedSlides?(e=x.slides.length-3*x.loopedSlides+x.activeIndex,e+=x.loopedSlides,x.slideTo(e,0,!1,!0)):("auto"===x.params.slidesPerView&&x.activeIndex>=2*x.loopedSlides||x.activeIndex>x.slides.length-2*x.params.slidesPerView)&&(e=-x.slides.length+x.activeIndex+x.loopedSlides,e+=x.loopedSlides,x.slideTo(e,0,!1,!0))},x.appendSlide=function(e){if(x.params.loop&&x.destroyLoop(),"object"==typeof e&&e.length)for(var a=0;a<e.length;a++)e[a]&&x.wrapper.append(e[a]);else x.wrapper.append(e);x.params.loop&&x.createLoop(),x.params.observer&&x.support.observer||x.update(!0)},x.prependSlide=function(e){x.params.loop&&x.destroyLoop();var a=x.activeIndex+1;if("object"==typeof e&&e.length){for(var t=0;t<e.length;t++)e[t]&&x.wrapper.prepend(e[t]);a=x.activeIndex+e.length}else x.wrapper.prepend(e);x.params.loop&&x.createLoop(),x.params.observer&&x.support.observer||x.update(!0),x.slideTo(a,0,!1)},x.removeSlide=function(e){x.params.loop&&(x.destroyLoop(),x.slides=x.wrapper.children("."+x.params.slideClass));var a,t=x.activeIndex;if("object"==typeof e&&e.length){for(var s=0;s<e.length;s++)a=e[s],x.slides[a]&&x.slides.eq(a).remove(),a<t&&t--;t=Math.max(t,0)}else a=e,x.slides[a]&&x.slides.eq(a).remove(),a<t&&t--,t=Math.max(t,0);x.params.loop&&x.createLoop(),x.params.observer&&x.support.observer||x.update(!0),x.params.loop?x.slideTo(t+x.loopedSlides,0,!1):x.slideTo(t,0,!1)},x.removeAllSlides=function(){for(var e=[],a=0;a<x.slides.length;a++)e.push(a);x.removeSlide(e)},x.effects={fade:{setTranslate:function(){for(var e=0;e<x.slides.length;e++){var a=x.slides.eq(e),t=a[0].swiperSlideOffset,s=-t;x.params.virtualTranslate||(s-=x.translate);var r=0;x.isHorizontal()||(r=s,s=0);var i=x.params.fade.crossFade?Math.max(1-Math.abs(a[0].progress),0):1+Math.min(Math.max(a[0].progress,-1),0);a.css({opacity:i}).transform("translate3d("+s+"px, "+r+"px, 0px)")}},setTransition:function(e){if(x.slides.transition(e),x.params.virtualTranslate&&0!==e){var a=!1;x.slides.transitionEnd(function(){if(!a&&x){a=!0,x.animating=!1;for(var e=["webkitTransitionEnd","transitionend","oTransitionEnd","MSTransitionEnd","msTransitionEnd"],t=0;t<e.length;t++)x.wrapper.trigger(e[t])}})}}},flip:{setTranslate:function(){for(var a=0;a<x.slides.length;a++){var t=x.slides.eq(a),s=t[0].progress;x.params.flip.limitRotation&&(s=Math.max(Math.min(t[0].progress,1),-1));var r=t[0].swiperSlideOffset,i=-180*s,n=i,o=0,l=-r,p=0;if(x.isHorizontal()?x.rtl&&(n=-n):(p=l,l=0,o=-n,n=0),t[0].style.zIndex=-Math.abs(Math.round(s))+x.slides.length,x.params.flip.slideShadows){var d=x.isHorizontal()?t.find(".swiper-slide-shadow-left"):t.find(".swiper-slide-shadow-top"),m=x.isHorizontal()?t.find(".swiper-slide-shadow-right"):t.find(".swiper-slide-shadow-bottom");0===d.length&&(d=e('<div class="swiper-slide-shadow-'+(x.isHorizontal()?"left":"top")+'"></div>'),t.append(d)),0===m.length&&(m=e('<div class="swiper-slide-shadow-'+(x.isHorizontal()?"right":"bottom")+'"></div>'),t.append(m)),d.length&&(d[0].style.opacity=Math.max(-s,0)),m.length&&(m[0].style.opacity=Math.max(s,0))}t.transform("translate3d("+l+"px, "+p+"px, 0px) rotateX("+o+"deg) rotateY("+n+"deg)")}},setTransition:function(a){if(x.slides.transition(a).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(a),x.params.virtualTranslate&&0!==a){var t=!1;x.slides.eq(x.activeIndex).transitionEnd(function(){if(!t&&x&&e(this).hasClass(x.params.slideActiveClass)){t=!0,x.animating=!1;for(var a=["webkitTransitionEnd","transitionend","oTransitionEnd","MSTransitionEnd","msTransitionEnd"],s=0;s<a.length;s++)x.wrapper.trigger(a[s])}})}}},cube:{setTranslate:function(){var a,t=0;x.params.cube.shadow&&(x.isHorizontal()?(a=x.wrapper.find(".swiper-cube-shadow"),0===a.length&&(a=e('<div class="swiper-cube-shadow"></div>'),x.wrapper.append(a)),a.css({height:x.width+"px"})):(a=x.container.find(".swiper-cube-shadow"),0===a.length&&(a=e('<div class="swiper-cube-shadow"></div>'),x.container.append(a))));for(var s=0;s<x.slides.length;s++){var r=x.slides.eq(s),i=90*s,n=Math.floor(i/360);x.rtl&&(i=-i,n=Math.floor(-i/360));var o=Math.max(Math.min(r[0].progress,1),-1),l=0,p=0,d=0;s%4==0?(l=4*-n*x.size,d=0):(s-1)%4==0?(l=0,d=4*-n*x.size):(s-2)%4==0?(l=x.size+4*n*x.size,d=x.size):(s-3)%4==0&&(l=-x.size,d=3*x.size+4*x.size*n),x.rtl&&(l=-l),x.isHorizontal()||(p=l,l=0);var m="rotateX("+(x.isHorizontal()?0:-i)+"deg) rotateY("+(x.isHorizontal()?i:0)+"deg) translate3d("+l+"px, "+p+"px, "+d+"px)";if(o<=1&&o>-1&&(t=90*s+90*o,x.rtl&&(t=90*-s-90*o)),r.transform(m),x.params.cube.slideShadows){var u=x.isHorizontal()?r.find(".swiper-slide-shadow-left"):r.find(".swiper-slide-shadow-top"),c=x.isHorizontal()?r.find(".swiper-slide-shadow-right"):r.find(".swiper-slide-shadow-bottom");0===u.length&&(u=e('<div class="swiper-slide-shadow-'+(x.isHorizontal()?"left":"top")+'"></div>'),r.append(u)),0===c.length&&(c=e('<div class="swiper-slide-shadow-'+(x.isHorizontal()?"right":"bottom")+'"></div>'),r.append(c)),u.length&&(u[0].style.opacity=Math.max(-o,0)),c.length&&(c[0].style.opacity=Math.max(o,0))}}if(x.wrapper.css({"-webkit-transform-origin":"50% 50% -"+x.size/2+"px","-moz-transform-origin":"50% 50% -"+x.size/2+"px","-ms-transform-origin":"50% 50% -"+x.size/2+"px","transform-origin":"50% 50% -"+x.size/2+"px"}),x.params.cube.shadow)if(x.isHorizontal())a.transform("translate3d(0px, "+(x.width/2+x.params.cube.shadowOffset)+"px, "+-x.width/2+"px) rotateX(90deg) rotateZ(0deg) scale("+x.params.cube.shadowScale+")");else{var g=Math.abs(t)-90*Math.floor(Math.abs(t)/90),h=1.5-(Math.sin(2*g*Math.PI/360)/2+Math.cos(2*g*Math.PI/360)/2),v=x.params.cube.shadowScale,f=x.params.cube.shadowScale/h,w=x.params.cube.shadowOffset;a.transform("scale3d("+v+", 1, "+f+") translate3d(0px, "+(x.height/2+w)+"px, "+-x.height/2/f+"px) rotateX(-90deg)")}var y=x.isSafari||x.isUiWebView?-x.size/2:0;x.wrapper.transform("translate3d(0px,0,"+y+"px) rotateX("+(x.isHorizontal()?0:t)+"deg) rotateY("+(x.isHorizontal()?-t:0)+"deg)")},setTransition:function(e){x.slides.transition(e).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(e),x.params.cube.shadow&&!x.isHorizontal()&&x.container.find(".swiper-cube-shadow").transition(e)}},coverflow:{setTranslate:function(){for(var a=x.translate,t=x.isHorizontal()?-a+x.width/2:-a+x.height/2,s=x.isHorizontal()?x.params.coverflow.rotate:-x.params.coverflow.rotate,r=x.params.coverflow.depth,i=0,n=x.slides.length;i<n;i++){var o=x.slides.eq(i),l=x.slidesSizesGrid[i],p=o[0].swiperSlideOffset,d=(t-p-l/2)/l*x.params.coverflow.modifier,m=x.isHorizontal()?s*d:0,u=x.isHorizontal()?0:s*d,c=-r*Math.abs(d),g=x.isHorizontal()?0:x.params.coverflow.stretch*d,h=x.isHorizontal()?x.params.coverflow.stretch*d:0;Math.abs(h)<.001&&(h=0),Math.abs(g)<.001&&(g=0),Math.abs(c)<.001&&(c=0),Math.abs(m)<.001&&(m=0),Math.abs(u)<.001&&(u=0);var v="translate3d("+h+"px,"+g+"px,"+c+"px)  rotateX("+u+"deg) rotateY("+m+"deg)";if(o.transform(v),o[0].style.zIndex=1-Math.abs(Math.round(d)),x.params.coverflow.slideShadows){var f=x.isHorizontal()?o.find(".swiper-slide-shadow-left"):o.find(".swiper-slide-shadow-top"),w=x.isHorizontal()?o.find(".swiper-slide-shadow-right"):o.find(".swiper-slide-shadow-bottom");0===f.length&&(f=e('<div class="swiper-slide-shadow-'+(x.isHorizontal()?"left":"top")+'"></div>'),o.append(f)),0===w.length&&(w=e('<div class="swiper-slide-shadow-'+(x.isHorizontal()?"right":"bottom")+'"></div>'),o.append(w)),f.length&&(f[0].style.opacity=d>0?d:0),w.length&&(w[0].style.opacity=-d>0?-d:0)}}if(x.browser.ie){x.wrapper[0].style.perspectiveOrigin=t+"px 50%"}},setTransition:function(e){x.slides.transition(e).find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").transition(e)}}},x.lazy={initialImageLoaded:!1,loadImageInSlide:function(a,t){if(void 0!==a&&(void 0===t&&(t=!0),0!==x.slides.length)){var s=x.slides.eq(a),r=s.find("."+x.params.lazyLoadingClass+":not(."+x.params.lazyStatusLoadedClass+"):not(."+x.params.lazyStatusLoadingClass+")");!s.hasClass(x.params.lazyLoadingClass)||s.hasClass(x.params.lazyStatusLoadedClass)||s.hasClass(x.params.lazyStatusLoadingClass)||(r=r.add(s[0])),0!==r.length&&r.each(function(){var a=e(this);a.addClass(x.params.lazyStatusLoadingClass);var r=a.attr("data-background"),i=a.attr("data-src"),n=a.attr("data-srcset"),o=a.attr("data-sizes");x.loadImage(a[0],i||r,n,o,!1,function(){if(void 0!==x&&null!==x&&x){if(r?(a.css("background-image",'url("'+r+'")'),a.removeAttr("data-background")):(n&&(a.attr("srcset",n),a.removeAttr("data-srcset")),o&&(a.attr("sizes",o),a.removeAttr("data-sizes")),i&&(a.attr("src",i),a.removeAttr("data-src"))),a.addClass(x.params.lazyStatusLoadedClass).removeClass(x.params.lazyStatusLoadingClass),s.find("."+x.params.lazyPreloaderClass+", ."+x.params.preloaderClass).remove(),x.params.loop&&t){var e=s.attr("data-swiper-slide-index");if(s.hasClass(x.params.slideDuplicateClass)){var l=x.wrapper.children('[data-swiper-slide-index="'+e+'"]:not(.'+x.params.slideDuplicateClass+")");x.lazy.loadImageInSlide(l.index(),!1)}else{var p=x.wrapper.children("."+x.params.slideDuplicateClass+'[data-swiper-slide-index="'+e+'"]');x.lazy.loadImageInSlide(p.index(),!1)}}x.emit("onLazyImageReady",x,s[0],a[0])}}),x.emit("onLazyImageLoad",x,s[0],a[0])})}},load:function(){var a,t=x.params.slidesPerView;if("auto"===t&&(t=0),x.lazy.initialImageLoaded||(x.lazy.initialImageLoaded=!0),x.params.watchSlidesVisibility)x.wrapper.children("."+x.params.slideVisibleClass).each(function(){x.lazy.loadImageInSlide(e(this).index())});else if(t>1)for(a=x.activeIndex;a<x.activeIndex+t;a++)x.slides[a]&&x.lazy.loadImageInSlide(a);else x.lazy.loadImageInSlide(x.activeIndex);if(x.params.lazyLoadingInPrevNext)if(t>1||x.params.lazyLoadingInPrevNextAmount&&x.params.lazyLoadingInPrevNextAmount>1){var s=x.params.lazyLoadingInPrevNextAmount,r=t,i=Math.min(x.activeIndex+r+Math.max(s,r),x.slides.length),n=Math.max(x.activeIndex-Math.max(r,s),0);for(a=x.activeIndex+t;a<i;a++)x.slides[a]&&x.lazy.loadImageInSlide(a);for(a=n;a<x.activeIndex;a++)x.slides[a]&&x.lazy.loadImageInSlide(a)}else{var o=x.wrapper.children("."+x.params.slideNextClass);o.length>0&&x.lazy.loadImageInSlide(o.index());var l=x.wrapper.children("."+x.params.slidePrevClass);l.length>0&&x.lazy.loadImageInSlide(l.index())}},onTransitionStart:function(){x.params.lazyLoading&&(x.params.lazyLoadingOnTransitionStart||!x.params.lazyLoadingOnTransitionStart&&!x.lazy.initialImageLoaded)&&x.lazy.load()},onTransitionEnd:function(){x.params.lazyLoading&&!x.params.lazyLoadingOnTransitionStart&&x.lazy.load()}},x.scrollbar={isTouched:!1,setDragPosition:function(e){var a=x.scrollbar,t=x.isHorizontal()?"touchstart"===e.type||"touchmove"===e.type?e.targetTouches[0].pageX:e.pageX||e.clientX:"touchstart"===e.type||"touchmove"===e.type?e.targetTouches[0].pageY:e.pageY||e.clientY,s=t-a.track.offset()[x.isHorizontal()?"left":"top"]-a.dragSize/2,r=-x.minTranslate()*a.moveDivider,i=-x.maxTranslate()*a.moveDivider;s<r?s=r:s>i&&(s=i),s=-s/a.moveDivider,x.updateProgress(s),x.setWrapperTranslate(s,!0)},dragStart:function(e){var a=x.scrollbar;a.isTouched=!0,e.preventDefault(),e.stopPropagation(),a.setDragPosition(e),clearTimeout(a.dragTimeout),a.track.transition(0),x.params.scrollbarHide&&a.track.css("opacity",1),x.wrapper.transition(100),a.drag.transition(100),x.emit("onScrollbarDragStart",x)},dragMove:function(e){var a=x.scrollbar;a.isTouched&&(e.preventDefault?e.preventDefault():e.returnValue=!1,a.setDragPosition(e),x.wrapper.transition(0),a.track.transition(0),a.drag.transition(0),x.emit("onScrollbarDragMove",x))},dragEnd:function(e){var a=x.scrollbar;a.isTouched&&(a.isTouched=!1,x.params.scrollbarHide&&(clearTimeout(a.dragTimeout),a.dragTimeout=setTimeout(function(){a.track.css("opacity",0),a.track.transition(400)},1e3)),x.emit("onScrollbarDragEnd",x),x.params.scrollbarSnapOnRelease&&x.slideReset())},draggableEvents:function(){return x.params.simulateTouch!==!1||x.support.touch?x.touchEvents:x.touchEventsDesktop}(),enableDraggable:function(){var a=x.scrollbar,t=x.support.touch?a.track:document;e(a.track).on(a.draggableEvents.start,a.dragStart),e(t).on(a.draggableEvents.move,a.dragMove),e(t).on(a.draggableEvents.end,a.dragEnd)},disableDraggable:function(){var a=x.scrollbar,t=x.support.touch?a.track:document;e(a.track).off(a.draggableEvents.start,a.dragStart),e(t).off(a.draggableEvents.move,a.dragMove),e(t).off(a.draggableEvents.end,a.dragEnd)},set:function(){if(x.params.scrollbar){var a=x.scrollbar;a.track=e(x.params.scrollbar),x.params.uniqueNavElements&&"string"==typeof x.params.scrollbar&&a.track.length>1&&1===x.container.find(x.params.scrollbar).length&&(a.track=x.container.find(x.params.scrollbar)),a.drag=a.track.find(".swiper-scrollbar-drag"),0===a.drag.length&&(a.drag=e('<div class="swiper-scrollbar-drag"></div>'),a.track.append(a.drag)),a.drag[0].style.width="",a.drag[0].style.height="",a.trackSize=x.isHorizontal()?a.track[0].offsetWidth:a.track[0].offsetHeight,a.divider=x.size/x.virtualSize,a.moveDivider=a.divider*(a.trackSize/x.size),a.dragSize=a.trackSize*a.divider,x.isHorizontal()?a.drag[0].style.width=a.dragSize+"px":a.drag[0].style.height=a.dragSize+"px",a.divider>=1?a.track[0].style.display="none":a.track[0].style.display="",x.params.scrollbarHide&&(a.track[0].style.opacity=0)}},setTranslate:function(){if(x.params.scrollbar){var e,a=x.scrollbar,t=(x.translate,a.dragSize);e=(a.trackSize-a.dragSize)*x.progress,x.rtl&&x.isHorizontal()?(e=-e,e>0?(t=a.dragSize-e,e=0):-e+a.dragSize>a.trackSize&&(t=a.trackSize+e)):e<0?(t=a.dragSize+e,e=0):e+a.dragSize>a.trackSize&&(t=a.trackSize-e),x.isHorizontal()?(x.support.transforms3d?a.drag.transform("translate3d("+e+"px, 0, 0)"):a.drag.transform("translateX("+e+"px)"),a.drag[0].style.width=t+"px"):(x.support.transforms3d?a.drag.transform("translate3d(0px, "+e+"px, 0)"):a.drag.transform("translateY("+e+"px)"),a.drag[0].style.height=t+"px"),x.params.scrollbarHide&&(clearTimeout(a.timeout),a.track[0].style.opacity=1,a.timeout=setTimeout(function(){a.track[0].style.opacity=0,a.track.transition(400)},1e3))}},setTransition:function(e){x.params.scrollbar&&x.scrollbar.drag.transition(e)}},x.controller={LinearSpline:function(e,a){var t=function(){var e,a,t;return function(s,r){for(a=-1,e=s.length;e-a>1;)s[t=e+a>>1]<=r?a=t:e=t;return e}}();this.x=e,this.y=a,this.lastIndex=e.length-1;var s,r;this.x.length;this.interpolate=function(e){return e?(r=t(this.x,e),s=r-1,(e-this.x[s])*(this.y[r]-this.y[s])/(this.x[r]-this.x[s])+this.y[s]):0}},getInterpolateFunction:function(e){x.controller.spline||(x.controller.spline=x.params.loop?new x.controller.LinearSpline(x.slidesGrid,e.slidesGrid):new x.controller.LinearSpline(x.snapGrid,e.snapGrid))},setTranslate:function(e,t){function s(a){e=a.rtl&&"horizontal"===a.params.direction?-x.translate:x.translate,"slide"===x.params.controlBy&&(x.controller.getInterpolateFunction(a),i=-x.controller.spline.interpolate(-e)),i&&"container"!==x.params.controlBy||(r=(a.maxTranslate()-a.minTranslate())/(x.maxTranslate()-x.minTranslate()),i=(e-x.minTranslate())*r+a.minTranslate()),x.params.controlInverse&&(i=a.maxTranslate()-i),a.updateProgress(i),a.setWrapperTranslate(i,!1,x),a.updateActiveIndex()}var r,i,n=x.params.control;if(Array.isArray(n))for(var o=0;o<n.length;o++)n[o]!==t&&n[o]instanceof a&&s(n[o]);else n instanceof a&&t!==n&&s(n)},setTransition:function(e,t){function s(a){a.setWrapperTransition(e,x),0!==e&&(a.onTransitionStart(),a.wrapper.transitionEnd(function(){i&&(a.params.loop&&"slide"===x.params.controlBy&&a.fixLoop(),a.onTransitionEnd())}))}var r,i=x.params.control;if(Array.isArray(i))for(r=0;r<i.length;r++)i[r]!==t&&i[r]instanceof a&&s(i[r]);else i instanceof a&&t!==i&&s(i)}},x.hashnav={onHashCange:function(e,a){var t=document.location.hash.replace("#","");t!==x.slides.eq(x.activeIndex).attr("data-hash")&&x.slideTo(x.wrapper.children("."+x.params.slideClass+'[data-hash="'+t+'"]').index())},attachEvents:function(a){var t=a?"off":"on";e(window)[t]("hashchange",x.hashnav.onHashCange)},setHash:function(){
if(x.hashnav.initialized&&x.params.hashnav)if(x.params.replaceState&&window.history&&window.history.replaceState)window.history.replaceState(null,null,"#"+x.slides.eq(x.activeIndex).attr("data-hash")||"");else{var e=x.slides.eq(x.activeIndex),a=e.attr("data-hash")||e.attr("data-history");document.location.hash=a||""}},init:function(){if(x.params.hashnav&&!x.params.history){x.hashnav.initialized=!0;var e=document.location.hash.replace("#","");if(e)for(var a=0,t=x.slides.length;a<t;a++){var s=x.slides.eq(a),r=s.attr("data-hash")||s.attr("data-history");if(r===e&&!s.hasClass(x.params.slideDuplicateClass)){var i=s.index();x.slideTo(i,0,x.params.runCallbacksOnInit,!0)}}x.params.hashnavWatchState&&x.hashnav.attachEvents()}},destroy:function(){x.params.hashnavWatchState&&x.hashnav.attachEvents(!0)}},x.history={init:function(){if(x.params.history){if(!window.history||!window.history.pushState)return x.params.history=!1,void(x.params.hashnav=!0);x.history.initialized=!0,this.paths=this.getPathValues(),(this.paths.key||this.paths.value)&&(this.scrollToSlide(0,this.paths.value,x.params.runCallbacksOnInit),x.params.replaceState||window.addEventListener("popstate",this.setHistoryPopState))}},setHistoryPopState:function(){x.history.paths=x.history.getPathValues(),x.history.scrollToSlide(x.params.speed,x.history.paths.value,!1)},getPathValues:function(){var e=window.location.pathname.slice(1).split("/"),a=e.length;return{key:e[a-2],value:e[a-1]}},setHistory:function(e,a){if(x.history.initialized&&x.params.history){var t=x.slides.eq(a),s=this.slugify(t.attr("data-history"));window.location.pathname.includes(e)||(s=e+"/"+s),x.params.replaceState?window.history.replaceState(null,null,s):window.history.pushState(null,null,s)}},slugify:function(e){return e.toString().toLowerCase().replace(/\s+/g,"-").replace(/[^\w\-]+/g,"").replace(/\-\-+/g,"-").replace(/^-+/,"").replace(/-+$/,"")},scrollToSlide:function(e,a,t){if(a)for(var s=0,r=x.slides.length;s<r;s++){var i=x.slides.eq(s),n=this.slugify(i.attr("data-history"));if(n===a&&!i.hasClass(x.params.slideDuplicateClass)){var o=i.index();x.slideTo(o,e,t)}}else x.slideTo(0,e,t)}},x.disableKeyboardControl=function(){x.params.keyboardControl=!1,e(document).off("keydown",l)},x.enableKeyboardControl=function(){x.params.keyboardControl=!0,e(document).on("keydown",l)},x.mousewheel={event:!1,lastScrollTime:(new window.Date).getTime()},x.params.mousewheelControl&&(x.mousewheel.event=navigator.userAgent.indexOf("firefox")>-1?"DOMMouseScroll":function(){var e="onwheel"in document;if(!e){var a=document.createElement("div");a.setAttribute("onwheel","return;"),e="function"==typeof a.onwheel}return!e&&document.implementation&&document.implementation.hasFeature&&document.implementation.hasFeature("","")!==!0&&(e=document.implementation.hasFeature("Events.wheel","3.0")),e}()?"wheel":"mousewheel"),x.disableMousewheelControl=function(){if(!x.mousewheel.event)return!1;var a=x.container;return"container"!==x.params.mousewheelEventsTarged&&(a=e(x.params.mousewheelEventsTarged)),a.off(x.mousewheel.event,d),x.params.mousewheelControl=!1,!0},x.enableMousewheelControl=function(){if(!x.mousewheel.event)return!1;var a=x.container;return"container"!==x.params.mousewheelEventsTarged&&(a=e(x.params.mousewheelEventsTarged)),a.on(x.mousewheel.event,d),x.params.mousewheelControl=!0,!0},x.parallax={setTranslate:function(){x.container.children("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function(){m(this,x.progress)}),x.slides.each(function(){var a=e(this);a.find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function(){m(this,Math.min(Math.max(a[0].progress,-1),1))})})},setTransition:function(a){void 0===a&&(a=x.params.speed),x.container.find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y]").each(function(){var t=e(this),s=parseInt(t.attr("data-swiper-parallax-duration"),10)||a;0===a&&(s=0),t.transition(s)})}},x.zoom={scale:1,currentScale:1,isScaling:!1,gesture:{slide:void 0,slideWidth:void 0,slideHeight:void 0,image:void 0,imageWrap:void 0,zoomMax:x.params.zoomMax},image:{isTouched:void 0,isMoved:void 0,currentX:void 0,currentY:void 0,minX:void 0,minY:void 0,maxX:void 0,maxY:void 0,width:void 0,height:void 0,startX:void 0,startY:void 0,touchesStart:{},touchesCurrent:{}},velocity:{x:void 0,y:void 0,prevPositionX:void 0,prevPositionY:void 0,prevTime:void 0},getDistanceBetweenTouches:function(e){if(e.targetTouches.length<2)return 1;var a=e.targetTouches[0].pageX,t=e.targetTouches[0].pageY,s=e.targetTouches[1].pageX,r=e.targetTouches[1].pageY;return Math.sqrt(Math.pow(s-a,2)+Math.pow(r-t,2))},onGestureStart:function(a){var t=x.zoom;if(!x.support.gestures){if("touchstart"!==a.type||"touchstart"===a.type&&a.targetTouches.length<2)return;t.gesture.scaleStart=t.getDistanceBetweenTouches(a)}if(!(t.gesture.slide&&t.gesture.slide.length||(t.gesture.slide=e(this),0===t.gesture.slide.length&&(t.gesture.slide=x.slides.eq(x.activeIndex)),t.gesture.image=t.gesture.slide.find("img, svg, canvas"),t.gesture.imageWrap=t.gesture.image.parent("."+x.params.zoomContainerClass),t.gesture.zoomMax=t.gesture.imageWrap.attr("data-swiper-zoom")||x.params.zoomMax,0!==t.gesture.imageWrap.length)))return void(t.gesture.image=void 0);t.gesture.image.transition(0),t.isScaling=!0},onGestureChange:function(e){var a=x.zoom;if(!x.support.gestures){if("touchmove"!==e.type||"touchmove"===e.type&&e.targetTouches.length<2)return;a.gesture.scaleMove=a.getDistanceBetweenTouches(e)}a.gesture.image&&0!==a.gesture.image.length&&(x.support.gestures?a.scale=e.scale*a.currentScale:a.scale=a.gesture.scaleMove/a.gesture.scaleStart*a.currentScale,a.scale>a.gesture.zoomMax&&(a.scale=a.gesture.zoomMax-1+Math.pow(a.scale-a.gesture.zoomMax+1,.5)),a.scale<x.params.zoomMin&&(a.scale=x.params.zoomMin+1-Math.pow(x.params.zoomMin-a.scale+1,.5)),a.gesture.image.transform("translate3d(0,0,0) scale("+a.scale+")"))},onGestureEnd:function(e){var a=x.zoom;!x.support.gestures&&("touchend"!==e.type||"touchend"===e.type&&e.changedTouches.length<2)||a.gesture.image&&0!==a.gesture.image.length&&(a.scale=Math.max(Math.min(a.scale,a.gesture.zoomMax),x.params.zoomMin),a.gesture.image.transition(x.params.speed).transform("translate3d(0,0,0) scale("+a.scale+")"),a.currentScale=a.scale,a.isScaling=!1,1===a.scale&&(a.gesture.slide=void 0))},onTouchStart:function(e,a){var t=e.zoom;t.gesture.image&&0!==t.gesture.image.length&&(t.image.isTouched||("android"===e.device.os&&a.preventDefault(),t.image.isTouched=!0,t.image.touchesStart.x="touchstart"===a.type?a.targetTouches[0].pageX:a.pageX,t.image.touchesStart.y="touchstart"===a.type?a.targetTouches[0].pageY:a.pageY))},onTouchMove:function(e){var a=x.zoom;if(a.gesture.image&&0!==a.gesture.image.length&&(x.allowClick=!1,a.image.isTouched&&a.gesture.slide)){a.image.isMoved||(a.image.width=a.gesture.image[0].offsetWidth,a.image.height=a.gesture.image[0].offsetHeight,a.image.startX=x.getTranslate(a.gesture.imageWrap[0],"x")||0,a.image.startY=x.getTranslate(a.gesture.imageWrap[0],"y")||0,a.gesture.slideWidth=a.gesture.slide[0].offsetWidth,a.gesture.slideHeight=a.gesture.slide[0].offsetHeight,a.gesture.imageWrap.transition(0),x.rtl&&(a.image.startX=-a.image.startX),x.rtl&&(a.image.startY=-a.image.startY));var t=a.image.width*a.scale,s=a.image.height*a.scale;if(!(t<a.gesture.slideWidth&&s<a.gesture.slideHeight)){if(a.image.minX=Math.min(a.gesture.slideWidth/2-t/2,0),a.image.maxX=-a.image.minX,a.image.minY=Math.min(a.gesture.slideHeight/2-s/2,0),a.image.maxY=-a.image.minY,a.image.touchesCurrent.x="touchmove"===e.type?e.targetTouches[0].pageX:e.pageX,a.image.touchesCurrent.y="touchmove"===e.type?e.targetTouches[0].pageY:e.pageY,!a.image.isMoved&&!a.isScaling){if(x.isHorizontal()&&Math.floor(a.image.minX)===Math.floor(a.image.startX)&&a.image.touchesCurrent.x<a.image.touchesStart.x||Math.floor(a.image.maxX)===Math.floor(a.image.startX)&&a.image.touchesCurrent.x>a.image.touchesStart.x)return void(a.image.isTouched=!1);if(!x.isHorizontal()&&Math.floor(a.image.minY)===Math.floor(a.image.startY)&&a.image.touchesCurrent.y<a.image.touchesStart.y||Math.floor(a.image.maxY)===Math.floor(a.image.startY)&&a.image.touchesCurrent.y>a.image.touchesStart.y)return void(a.image.isTouched=!1)}e.preventDefault(),e.stopPropagation(),a.image.isMoved=!0,a.image.currentX=a.image.touchesCurrent.x-a.image.touchesStart.x+a.image.startX,a.image.currentY=a.image.touchesCurrent.y-a.image.touchesStart.y+a.image.startY,a.image.currentX<a.image.minX&&(a.image.currentX=a.image.minX+1-Math.pow(a.image.minX-a.image.currentX+1,.8)),a.image.currentX>a.image.maxX&&(a.image.currentX=a.image.maxX-1+Math.pow(a.image.currentX-a.image.maxX+1,.8)),a.image.currentY<a.image.minY&&(a.image.currentY=a.image.minY+1-Math.pow(a.image.minY-a.image.currentY+1,.8)),a.image.currentY>a.image.maxY&&(a.image.currentY=a.image.maxY-1+Math.pow(a.image.currentY-a.image.maxY+1,.8)),a.velocity.prevPositionX||(a.velocity.prevPositionX=a.image.touchesCurrent.x),a.velocity.prevPositionY||(a.velocity.prevPositionY=a.image.touchesCurrent.y),a.velocity.prevTime||(a.velocity.prevTime=Date.now()),a.velocity.x=(a.image.touchesCurrent.x-a.velocity.prevPositionX)/(Date.now()-a.velocity.prevTime)/2,a.velocity.y=(a.image.touchesCurrent.y-a.velocity.prevPositionY)/(Date.now()-a.velocity.prevTime)/2,Math.abs(a.image.touchesCurrent.x-a.velocity.prevPositionX)<2&&(a.velocity.x=0),Math.abs(a.image.touchesCurrent.y-a.velocity.prevPositionY)<2&&(a.velocity.y=0),a.velocity.prevPositionX=a.image.touchesCurrent.x,a.velocity.prevPositionY=a.image.touchesCurrent.y,a.velocity.prevTime=Date.now(),a.gesture.imageWrap.transform("translate3d("+a.image.currentX+"px, "+a.image.currentY+"px,0)")}}},onTouchEnd:function(e,a){var t=e.zoom;if(t.gesture.image&&0!==t.gesture.image.length){if(!t.image.isTouched||!t.image.isMoved)return t.image.isTouched=!1,void(t.image.isMoved=!1);t.image.isTouched=!1,t.image.isMoved=!1;var s=300,r=300,i=t.velocity.x*s,n=t.image.currentX+i,o=t.velocity.y*r,l=t.image.currentY+o;0!==t.velocity.x&&(s=Math.abs((n-t.image.currentX)/t.velocity.x)),0!==t.velocity.y&&(r=Math.abs((l-t.image.currentY)/t.velocity.y));var p=Math.max(s,r);t.image.currentX=n,t.image.currentY=l;var d=t.image.width*t.scale,m=t.image.height*t.scale;t.image.minX=Math.min(t.gesture.slideWidth/2-d/2,0),t.image.maxX=-t.image.minX,t.image.minY=Math.min(t.gesture.slideHeight/2-m/2,0),t.image.maxY=-t.image.minY,t.image.currentX=Math.max(Math.min(t.image.currentX,t.image.maxX),t.image.minX),t.image.currentY=Math.max(Math.min(t.image.currentY,t.image.maxY),t.image.minY),t.gesture.imageWrap.transition(p).transform("translate3d("+t.image.currentX+"px, "+t.image.currentY+"px,0)")}},onTransitionEnd:function(e){var a=e.zoom;a.gesture.slide&&e.previousIndex!==e.activeIndex&&(a.gesture.image.transform("translate3d(0,0,0) scale(1)"),a.gesture.imageWrap.transform("translate3d(0,0,0)"),a.gesture.slide=a.gesture.image=a.gesture.imageWrap=void 0,a.scale=a.currentScale=1)},toggleZoom:function(a,t){var s=a.zoom;if(s.gesture.slide||(s.gesture.slide=a.clickedSlide?e(a.clickedSlide):a.slides.eq(a.activeIndex),s.gesture.image=s.gesture.slide.find("img, svg, canvas"),s.gesture.imageWrap=s.gesture.image.parent("."+a.params.zoomContainerClass)),s.gesture.image&&0!==s.gesture.image.length){var r,i,n,o,l,p,d,m,u,c,g,h,v,f,w,y,x,T;void 0===s.image.touchesStart.x&&t?(r="touchend"===t.type?t.changedTouches[0].pageX:t.pageX,i="touchend"===t.type?t.changedTouches[0].pageY:t.pageY):(r=s.image.touchesStart.x,i=s.image.touchesStart.y),s.scale&&1!==s.scale?(s.scale=s.currentScale=1,s.gesture.imageWrap.transition(300).transform("translate3d(0,0,0)"),s.gesture.image.transition(300).transform("translate3d(0,0,0) scale(1)"),s.gesture.slide=void 0):(s.scale=s.currentScale=s.gesture.imageWrap.attr("data-swiper-zoom")||a.params.zoomMax,t?(x=s.gesture.slide[0].offsetWidth,T=s.gesture.slide[0].offsetHeight,n=s.gesture.slide.offset().left,o=s.gesture.slide.offset().top,l=n+x/2-r,p=o+T/2-i,u=s.gesture.image[0].offsetWidth,c=s.gesture.image[0].offsetHeight,g=u*s.scale,h=c*s.scale,v=Math.min(x/2-g/2,0),f=Math.min(T/2-h/2,0),w=-v,y=-f,d=l*s.scale,m=p*s.scale,d<v&&(d=v),d>w&&(d=w),m<f&&(m=f),m>y&&(m=y)):(d=0,m=0),s.gesture.imageWrap.transition(300).transform("translate3d("+d+"px, "+m+"px,0)"),s.gesture.image.transition(300).transform("translate3d(0,0,0) scale("+s.scale+")"))}},attachEvents:function(a){var t=a?"off":"on";if(x.params.zoom){var s=(x.slides,!("touchstart"!==x.touchEvents.start||!x.support.passiveListener||!x.params.passiveListeners)&&{passive:!0,capture:!1});x.support.gestures?(x.slides[t]("gesturestart",x.zoom.onGestureStart,s),x.slides[t]("gesturechange",x.zoom.onGestureChange,s),x.slides[t]("gestureend",x.zoom.onGestureEnd,s)):"touchstart"===x.touchEvents.start&&(x.slides[t](x.touchEvents.start,x.zoom.onGestureStart,s),x.slides[t](x.touchEvents.move,x.zoom.onGestureChange,s),x.slides[t](x.touchEvents.end,x.zoom.onGestureEnd,s)),x[t]("touchStart",x.zoom.onTouchStart),x.slides.each(function(a,s){e(s).find("."+x.params.zoomContainerClass).length>0&&e(s)[t](x.touchEvents.move,x.zoom.onTouchMove)}),x[t]("touchEnd",x.zoom.onTouchEnd),x[t]("transitionEnd",x.zoom.onTransitionEnd),x.params.zoomToggle&&x.on("doubleTap",x.zoom.toggleZoom)}},init:function(){x.zoom.attachEvents()},destroy:function(){x.zoom.attachEvents(!0)}},x._plugins=[];for(var Y in x.plugins){var A=x.plugins[Y](x,x.params[Y]);A&&x._plugins.push(A)}return x.callPlugins=function(e){for(var a=0;a<x._plugins.length;a++)e in x._plugins[a]&&x._plugins[a][e](arguments[1],arguments[2],arguments[3],arguments[4],arguments[5])},x.emitterEventListeners={},x.emit=function(e){x.params[e]&&x.params[e](arguments[1],arguments[2],arguments[3],arguments[4],arguments[5]);var a;if(x.emitterEventListeners[e])for(a=0;a<x.emitterEventListeners[e].length;a++)x.emitterEventListeners[e][a](arguments[1],arguments[2],arguments[3],arguments[4],arguments[5]);x.callPlugins&&x.callPlugins(e,arguments[1],arguments[2],arguments[3],arguments[4],arguments[5])},x.on=function(e,a){return e=u(e),x.emitterEventListeners[e]||(x.emitterEventListeners[e]=[]),x.emitterEventListeners[e].push(a),x},x.off=function(e,a){var t;if(e=u(e),void 0===a)return x.emitterEventListeners[e]=[],x;if(x.emitterEventListeners[e]&&0!==x.emitterEventListeners[e].length){for(t=0;t<x.emitterEventListeners[e].length;t++)x.emitterEventListeners[e][t]===a&&x.emitterEventListeners[e].splice(t,1);return x}},x.once=function(e,a){e=u(e);var t=function(){a(arguments[0],arguments[1],arguments[2],arguments[3],arguments[4]),x.off(e,t)};return x.on(e,t),x},x.a11y={makeFocusable:function(e){return e.attr("tabIndex","0"),e},addRole:function(e,a){return e.attr("role",a),e},addLabel:function(e,a){return e.attr("aria-label",a),e},disable:function(e){return e.attr("aria-disabled",!0),e},enable:function(e){return e.attr("aria-disabled",!1),e},onEnterKey:function(a){13===a.keyCode&&(e(a.target).is(x.params.nextButton)?(x.onClickNext(a),x.isEnd?x.a11y.notify(x.params.lastSlideMessage):x.a11y.notify(x.params.nextSlideMessage)):e(a.target).is(x.params.prevButton)&&(x.onClickPrev(a),x.isBeginning?x.a11y.notify(x.params.firstSlideMessage):x.a11y.notify(x.params.prevSlideMessage)),e(a.target).is("."+x.params.bulletClass)&&e(a.target)[0].click())},liveRegion:e('<span class="'+x.params.notificationClass+'" aria-live="assertive" aria-atomic="true"></span>'),notify:function(e){var a=x.a11y.liveRegion;0!==a.length&&(a.html(""),a.html(e))},init:function(){x.params.nextButton&&x.nextButton&&x.nextButton.length>0&&(x.a11y.makeFocusable(x.nextButton),x.a11y.addRole(x.nextButton,"button"),x.a11y.addLabel(x.nextButton,x.params.nextSlideMessage)),x.params.prevButton&&x.prevButton&&x.prevButton.length>0&&(x.a11y.makeFocusable(x.prevButton),x.a11y.addRole(x.prevButton,"button"),x.a11y.addLabel(x.prevButton,x.params.prevSlideMessage)),e(x.container).append(x.a11y.liveRegion)},initPagination:function(){x.params.pagination&&x.params.paginationClickable&&x.bullets&&x.bullets.length&&x.bullets.each(function(){var a=e(this);x.a11y.makeFocusable(a),x.a11y.addRole(a,"button"),x.a11y.addLabel(a,x.params.paginationBulletMessage.replace(/{{index}}/,a.index()+1))})},destroy:function(){x.a11y.liveRegion&&x.a11y.liveRegion.length>0&&x.a11y.liveRegion.remove()}},x.init=function(){x.params.loop&&x.createLoop(),x.updateContainerSize(),x.updateSlidesSize(),x.updatePagination(),x.params.scrollbar&&x.scrollbar&&(x.scrollbar.set(),x.params.scrollbarDraggable&&x.scrollbar.enableDraggable()),"slide"!==x.params.effect&&x.effects[x.params.effect]&&(x.params.loop||x.updateProgress(),x.effects[x.params.effect].setTranslate()),x.params.loop?x.slideTo(x.params.initialSlide+x.loopedSlides,0,x.params.runCallbacksOnInit):(x.slideTo(x.params.initialSlide,0,x.params.runCallbacksOnInit),0===x.params.initialSlide&&(x.parallax&&x.params.parallax&&x.parallax.setTranslate(),x.lazy&&x.params.lazyLoading&&(x.lazy.load(),x.lazy.initialImageLoaded=!0))),x.attachEvents(),x.params.observer&&x.support.observer&&x.initObservers(),x.params.preloadImages&&!x.params.lazyLoading&&x.preloadImages(),x.params.zoom&&x.zoom&&x.zoom.init(),x.params.autoplay&&x.startAutoplay(),x.params.keyboardControl&&x.enableKeyboardControl&&x.enableKeyboardControl(),x.params.mousewheelControl&&x.enableMousewheelControl&&x.enableMousewheelControl(),x.params.hashnavReplaceState&&(x.params.replaceState=x.params.hashnavReplaceState),x.params.history&&x.history&&x.history.init(),x.params.hashnav&&x.hashnav&&x.hashnav.init(),x.params.a11y&&x.a11y&&x.a11y.init(),x.emit("onInit",x)},x.cleanupStyles=function(){x.container.removeClass(x.classNames.join(" ")).removeAttr("style"),x.wrapper.removeAttr("style"),x.slides&&x.slides.length&&x.slides.removeClass([x.params.slideVisibleClass,x.params.slideActiveClass,x.params.slideNextClass,x.params.slidePrevClass].join(" ")).removeAttr("style").removeAttr("data-swiper-column").removeAttr("data-swiper-row"),x.paginationContainer&&x.paginationContainer.length&&x.paginationContainer.removeClass(x.params.paginationHiddenClass),x.bullets&&x.bullets.length&&x.bullets.removeClass(x.params.bulletActiveClass),x.params.prevButton&&e(x.params.prevButton).removeClass(x.params.buttonDisabledClass),x.params.nextButton&&e(x.params.nextButton).removeClass(x.params.buttonDisabledClass),x.params.scrollbar&&x.scrollbar&&(x.scrollbar.track&&x.scrollbar.track.length&&x.scrollbar.track.removeAttr("style"),x.scrollbar.drag&&x.scrollbar.drag.length&&x.scrollbar.drag.removeAttr("style"))},x.destroy=function(e,a){x.detachEvents(),x.stopAutoplay(),x.params.scrollbar&&x.scrollbar&&x.params.scrollbarDraggable&&x.scrollbar.disableDraggable(),x.params.loop&&x.destroyLoop(),a&&x.cleanupStyles(),x.disconnectObservers(),x.params.zoom&&x.zoom&&x.zoom.destroy(),x.params.keyboardControl&&x.disableKeyboardControl&&x.disableKeyboardControl(),x.params.mousewheelControl&&x.disableMousewheelControl&&x.disableMousewheelControl(),x.params.a11y&&x.a11y&&x.a11y.destroy(),x.params.history&&!x.params.replaceState&&window.removeEventListener("popstate",x.history.setHistoryPopState),x.params.hashnav&&x.hashnav&&x.hashnav.destroy(),x.emit("onDestroy"),e!==!1&&(x=null)},x.init(),x}};a.prototype={isSafari:function(){var e=window.navigator.userAgent.toLowerCase();return e.indexOf("safari")>=0&&e.indexOf("chrome")<0&&e.indexOf("android")<0}(),isUiWebView:/(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(window.navigator.userAgent),isArray:function(e){return"[object Array]"===Object.prototype.toString.apply(e)},browser:{ie:window.navigator.pointerEnabled||window.navigator.msPointerEnabled,ieTouch:window.navigator.msPointerEnabled&&window.navigator.msMaxTouchPoints>1||window.navigator.pointerEnabled&&window.navigator.maxTouchPoints>1,lteIE9:function(){var e=document.createElement("div");return e.innerHTML="<!--[if lte IE 9]><i></i><![endif]-->",1===e.getElementsByTagName("i").length}()},device:function(){var e=window.navigator.userAgent,a=e.match(/(Android);?[\s\/]+([\d.]+)?/),t=e.match(/(iPad).*OS\s([\d_]+)/),s=e.match(/(iPod)(.*OS\s([\d_]+))?/),r=!t&&e.match(/(iPhone\sOS|iOS)\s([\d_]+)/);return{ios:t||r||s,android:a}}(),support:{touch:window.Modernizr&&Modernizr.touch===!0||function(){return!!("ontouchstart"in window||window.DocumentTouch&&document instanceof DocumentTouch)}(),transforms3d:window.Modernizr&&Modernizr.csstransforms3d===!0||function(){var e=document.createElement("div").style;return"webkitPerspective"in e||"MozPerspective"in e||"OPerspective"in e||"MsPerspective"in e||"perspective"in e}(),flexbox:function(){for(var e=document.createElement("div").style,a="alignItems webkitAlignItems webkitBoxAlign msFlexAlign mozBoxAlign webkitFlexDirection msFlexDirection mozBoxDirection mozBoxOrient webkitBoxDirection webkitBoxOrient".split(" "),t=0;t<a.length;t++)if(a[t]in e)return!0}(),observer:function(){return"MutationObserver"in window||"WebkitMutationObserver"in window}(),passiveListener:function(){var e=!1;try{var a=Object.defineProperty({},"passive",{get:function(){e=!0}});window.addEventListener("testPassiveListener",null,a)}catch(e){}return e}(),gestures:function(){return"ongesturestart"in window}()},plugins:{}};for(var t=["jQuery","Zepto","Dom7"],s=0;s<t.length;s++)window[t[s]]&&function(e){e.fn.swiper=function(t){var s;return e(this).each(function(){var e=new a(this,t);s||(s=e)}),s}}(window[t[s]]);var r;r="undefined"==typeof Dom7?window.Dom7||window.Zepto||window.jQuery:Dom7,r&&("transitionEnd"in r.fn||(r.fn.transitionEnd=function(e){function a(i){if(i.target===this)for(e.call(this,i),t=0;t<s.length;t++)r.off(s[t],a)}var t,s=["webkitTransitionEnd","transitionend","oTransitionEnd","MSTransitionEnd","msTransitionEnd"],r=this;if(e)for(t=0;t<s.length;t++)r.on(s[t],a);return this}),"transform"in r.fn||(r.fn.transform=function(e){for(var a=0;a<this.length;a++){var t=this[a].style;t.webkitTransform=t.MsTransform=t.msTransform=t.MozTransform=t.OTransform=t.transform=e}return this}),"transition"in r.fn||(r.fn.transition=function(e){"string"!=typeof e&&(e+="ms");for(var a=0;a<this.length;a++){var t=this[a].style;t.webkitTransitionDuration=t.MsTransitionDuration=t.msTransitionDuration=t.MozTransitionDuration=t.OTransitionDuration=t.transitionDuration=e}return this}),"outerWidth"in r.fn||(r.fn.outerWidth=function(e){return this.length>0?e?this[0].offsetWidth+parseFloat(this.css("margin-right"))+parseFloat(this.css("margin-left")):this[0].offsetWidth:null})),window.Swiper=a}(),"undefined"!=typeof module?module.exports=window.Swiper:"function"==typeof define&&define.amd&&define([],function(){"use strict";return window.Swiper});
//# sourceMappingURL=maps/swiper.jquery.min.js.map
/*!
 * Lazy Load - jQuery plugin for lazy loading images
 *
 * Copyright (c) 2007-2015 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/lazyload
 *
 * Version:  1.9.7
 *
 */
(function($, window, document, undefined) {
    var $window = $(window),
        canvasPosition=function(from_dom,to_dom){ // canvas璁剧疆
            var top=from_dom.position().top,
                left=from_dom.position().left,
                width=from_dom.width(),
                height=from_dom.height();
            to_dom.css({top:top,left:left}).width(width).height(height);
        },
        canvasControl=function(dom,canvas_id){
            $.stackBlurImage(dom, canvas_id, 10, false);
            if(dom.is(':visible')) canvasPosition(dom,$('#'+canvas_id));
            $(window).resize(function() {
                if(dom.is(":visible")) canvasPosition(dom,$('#'+canvas_id));
            });
            $('#'+canvas_id).attr({'data-load':true});
        },
        thumbdir=M['weburl']+'include/thumb.php?dir=';
    $.fn.lazyload = function(options) {
        var elements = this;
        var $container;
        var settings = {
            threshold       : 30,
            failure_limit   : 1000,
            event           : "scroll",
            effect          : "fadeIn",
            effect_speed    : null,
            container       : window,
            data_attribute  : "original",
            data_srcset     : 'srcset',
            skip_invisible  : true,
            appear          : null,
            load            : null,
            placeholder     : met_lazyloadbg,// 'base64',met_lazyloadbg,'blur'
        };

        function update() {
            var counter = 0;

            elements.each(function() {
                var $this = $(this),
                    $this_canvas=$this.next('canvas');
                if (settings.skip_invisible && !$this.is(":visible")) {
                    return;
                }
                if($this_canvas.length && !$this_canvas.attr('data-load') && $.stackBlurImage) canvasControl($this,$this_canvas.attr('id'));
                if ($.abovethetop(this, settings) ||
                    $.leftofbegin(this, settings)) {
                        /* Nothing. */
                } else if (!$.belowthefold(this, settings) &&
                    !$.rightoffold(this, settings)) {
                        $this.trigger("appear");
                        /* if we found an image we'll load, reset the counter */
                        counter = 0;
                } else {
                    if (++counter > settings.failure_limit) {
                        return false;
                    }
                }
            });

        }

        if(options) {
            /* Maintain BC for a couple of versions. */
            if (undefined !== options.failurelimit) {
                options.failure_limit = options.failurelimit;
                delete options.failurelimit;
            }
            if (undefined !== options.effectspeed) {
                options.effect_speed = options.effectspeed;
                delete options.effectspeed;
            }

            $.extend(settings, options);
        }

        /* Cache container as jQuery as object. */
        $container = (settings.container === undefined ||
                      settings.container === window) ? $window : $(settings.container);

        /* Fire one scroll event per scroll. Not one scroll event per image. */
        if (0 === settings.event.indexOf("scroll")) {
            $container.on(settings.event, function() {
                return update();
            });
        }
        if(settings.placeholder=='base64') settings.placeholder=met_lazyloadbg_base64;

        this.each(function(index) {
            var self = this,
                $self = $(self),
                original = $self.attr("data-" + settings.data_attribute),
                placeholder=settings.placeholder,
                placeholder_ok=placeholder!=met_lazyloadbg_base64?true:false;
            self.loaded = false;

            /* If no src attribute given use data:uri. */
            if ($self.is("img") && original && (!$self.attr("src") || $self.attr("src")!=original)) {
                if(placeholder=='blur' && $.stackBlurImage){
                    // 鍥剧墖楂樻柉妯＄硦鍔犺浇灏忓浘
                    if(!$self.attr('data-minimg')){
                        // 璁剧疆灏忓浘璺緞
                        var thumb=original.replace(M['weburl'],M['weburl']),
                            original_array=thumb.split('&');
                        if(thumb.indexOf('http')<0 || (thumb.indexOf('http')>=0 && thumb.indexOf(M['weburl'])>=0)){
                            if(original.indexOf('include/thumb.php?dir=')>-1){
                                var data_minimg=original_array[0]+'&x=50';
                            }else{
                                var data_minimg=thumbdir+thumb+'&x=50';
                            }
                            if(original_array && original_array.length==3){
                                scale_x=original_array[1].substring(2);
                                scale_y=original_array[2].substring(2);
                                scale=scale_y/scale_x;
                                minimg_h=Math.round(50*scale);
                                data_minimg+='&y='+minimg_h;
                            }
                            $(this).attr({src:data_minimg,'data-minimg':true});
                            // 楂樻柉妯＄硦灏忓浘
                            var img=new Image();
                            img.src=$self.attr("src");
                            img.onload=function(){
                                setTimeout(function(){
                                    var $self_canvas=$self.next('canvas');
                                    if($self.attr('src')!=original && !$self_canvas.length){
                                        var canvas_id="imgcanvas"+index;
                                        $self.wrapAll('<section style="position: relative;"></section>').after('<canvas id="'+canvas_id+'" data-load="false" width="'+$self.width()+'" height="'+$self.height()+'" style="position:absolute;z-index:10;"></canvas>');
                                        if(!settings.skip_invisible || $self.is(":visible")) canvasControl($self,canvas_id);
                                    }else if($self_canvas.length){
                                        canvasPosition($self,$self_canvas);
                                    }
                                },30)
                            }
                        }
                    }
                }else{
                    if(placeholder=='blur') placeholder=met_lazyloadbg;
                    $self.attr("src", placeholder);
                    if(placeholder_ok && !$self.hasClass('imgloading')) $self.addClass('imgloading');
                }
            }

            /* When appear is triggered load original image. */
            $self.one("appear", function() {
                if (!this.loaded) {
                    if (settings.appear) {
                        var elements_left = elements.length;
                        settings.appear.call(self, elements_left, settings);
                    }
                    var srcset = $self.attr("data-" + settings.data_srcset);
                    $("<img />")
                        .one("load", function() {
                        $self.hide();
                        if ($self.is("img")/* || $self.is("source") || $self.is("video") || $self.is("audio") || $self.is("iframe") || $self.is("script") || $self.is("link")*/) {
                            if(srcset) $self.attr("srcset", srcset);
                            $self.attr("src", original);
                        } else {
                            $self.css("background-image", "url('" + original + "')");
                            if(srcset) $self.css("background-image", "-webkit-image-set(" + srcset + ")");
                        }
                        $self[settings.effect](settings.effect_speed);
                        $self.one('load', function() {
                            $self.removeClass('imgloading');
                            $self.next('canvas').fadeOut("normal",function(){
                                $self.next('canvas').remove();
                            });
                        });

                        self.loaded = true;

                        /* Remove image from array so it is not looped next time. */
                        var temp = $.grep(elements, function(element) {
                            return !element.loaded;
                        });
                        elements = $(temp);

                        if (settings.load) {
                            var elements_left = elements.length;
                            settings.load.call(self, elements_left, settings);
                        }
                    }).attr({srcset:srcset,src:original}).removeClass('imgloading').next('canvas').fadeOut("normal",function(){
                        $("<img />").next('canvas').remove();
                    });
                }
            });

            /* When wanted event is triggered load original image */
            /* by triggering appear.                              */
            if (0 !== settings.event.indexOf("scroll")) {
                $self.on(settings.event, function() {
                    if (!self.loaded) {
                        $self.trigger("appear");
                    }
                });
            }
        });

        /* Check if something appears when window is resized. */
        $window.on("resize", function() {
            update();
        });

        /* With IOS5 force loading images when navigating with back button. */
        /* Non optimal workaround. */
        if ((/(?:iphone|ipod|ipad).*os 5/gi).test(navigator.appVersion)) {
            $window.on("pageshow", function(event) {
                if (event.originalEvent && event.originalEvent.persisted) {
                    elements.each(function() {
                        $(this).trigger("appear");
                    });
                }
            });
        }

        /* Force initial check if images should appear. */
        $(document).ready(function() {
            update();
        });

        return this;
    };

    /* Convenience methods in jQuery namespace.           */
    /* Use as  $.belowthefold(element, {threshold : 100, container : window}) */

    $.belowthefold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = (window.innerHeight ? window.innerHeight : $window.height()) + $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top + $(settings.container).height();
        }

        return fold <= $(element).offset().top - settings.threshold;
    };

    $.rightoffold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.width() + $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left + $(settings.container).width();
        }

        return fold <= $(element).offset().left - settings.threshold;
    };

    $.abovethetop = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top;
        }

        return fold >= $(element).offset().top + settings.threshold  + $(element).height();
    };

    $.leftofbegin = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left;
        }

        return fold >= $(element).offset().left + settings.threshold + $(element).width();
    };

    $.inviewport = function(element, settings) {
         return !$.rightoffold(element, settings) && !$.leftofbegin(element, settings) &&
                !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
     };

    /* Custom selectors for your convenience.   */
    /* Use as $("img:below-the-fold").something() or */
    /* $("img").filter(":below-the-fold").something() which is faster */

    $.extend($.expr[":"], {
        "below-the-fold" : function(a) { return $.belowthefold(a, {threshold : 0}); },
        "above-the-top"  : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-screen": function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-screen" : function(a) { return !$.rightoffold(a, {threshold : 0}); },
        "in-viewport"    : function(a) { return $.inviewport(a, {threshold : 0}); },
        /* Maintain BC for couple of versions. */
        "above-the-fold" : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-fold"  : function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-fold"   : function(a) { return !$.rightoffold(a, {threshold : 0}); }
    });

})(jQuery, window, document);

/*! lightgallery - v1.3.9 - 2017-03-05
* http://sachinchoolur.github.io/lightGallery/
* Copyright (c) 2017 Sachin N; Licensed GPLv3 */
!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(a.jQuery)}(this,function(a){!function(){"use strict";function b(b,d){if(this.el=b,this.$el=a(b),this.s=a.extend({},c,d),this.s.dynamic&&"undefined"!==this.s.dynamicEl&&this.s.dynamicEl.constructor===Array&&!this.s.dynamicEl.length)throw"When using dynamic mode, you must also define dynamicEl as an Array.";return this.modules={},this.lGalleryOn=!1,this.lgBusy=!1,this.hideBartimeout=!1,this.isTouch="ontouchstart"in document.documentElement,this.s.slideEndAnimatoin&&(this.s.hideControlOnEnd=!1),this.s.dynamic?this.$items=this.s.dynamicEl:"this"===this.s.selector?this.$items=this.$el:""!==this.s.selector?this.s.selectWithin?this.$items=a(this.s.selectWithin).find(this.s.selector):this.$items=this.$el.find(a(this.s.selector)):this.$items=this.$el.children(),this.$slide="",this.$outer="",this.init(),this}var c={mode:"lg-slide",cssEasing:"ease",easing:"linear",speed:600,height:"100%",width:"100%",addClass:"",startClass:"lg-start-zoom",backdropDuration:150,hideBarsDelay:6e3,useLeft:!1,closable:!0,loop:!0,escKey:!0,keyPress:!0,controls:!0,slideEndAnimatoin:!0,hideControlOnEnd:!1,mousewheel:!0,getCaptionFromTitleOrAlt:!0,appendSubHtmlTo:".lg-sub-html",subHtmlSelectorRelative:!1,preload:1,showAfterLoad:!0,selector:"",selectWithin:"",nextHtml:"",prevHtml:"",index:!1,iframeMaxWidth:"100%",download:!0,counter:!0,appendCounterTo:".lg-toolbar",swipeThreshold:50,enableSwipe:!0,enableDrag:!0,dynamic:!1,dynamicEl:[],galleryId:1};b.prototype.init=function(){var b=this;b.s.preload>b.$items.length&&(b.s.preload=b.$items.length);var c=window.location.hash;c.indexOf("lg="+this.s.galleryId)>0&&(b.index=parseInt(c.split("&slide=")[1],10),a("body").addClass("lg-from-hash"),a("body").hasClass("lg-on")||(setTimeout(function(){b.build(b.index)}),a("body").addClass("lg-on"))),b.s.dynamic?(b.$el.trigger("onBeforeOpen.lg"),b.index=b.s.index||0,a("body").hasClass("lg-on")||setTimeout(function(){b.build(b.index),a("body").addClass("lg-on")})):b.$items.on("click.lgcustom",function(c){try{c.preventDefault(),c.preventDefault()}catch(a){c.returnValue=!1}b.$el.trigger("onBeforeOpen.lg"),b.index=b.s.index||b.$items.index(this),a("body").hasClass("lg-on")||(b.build(b.index),a("body").addClass("lg-on"))})},b.prototype.build=function(b){var c=this;c.structure(),a.each(a.fn.lightGallery.modules,function(b){c.modules[b]=new a.fn.lightGallery.modules[b](c.el)}),c.slide(b,!1,!1,!1),c.s.keyPress&&c.keyPress(),c.$items.length>1&&(c.arrow(),setTimeout(function(){c.enableDrag(),c.enableSwipe()},50),c.s.mousewheel&&c.mousewheel()),c.counter(),c.closeGallery(),c.$el.trigger("onAfterOpen.lg"),c.$outer.on("mousemove.lg click.lg touchstart.lg",function(){c.$outer.removeClass("lg-hide-items"),clearTimeout(c.hideBartimeout),c.hideBartimeout=setTimeout(function(){c.$outer.addClass("lg-hide-items")},c.s.hideBarsDelay)}),c.$outer.trigger("mousemove.lg")},b.prototype.structure=function(){var b,c="",d="",e=0,f="",g=this;for(a("body").append('<div class="lg-backdrop"></div>'),a(".lg-backdrop").css("transition-duration",this.s.backdropDuration+"ms"),e=0;e<this.$items.length;e++)c+='<div class="lg-item"></div>';if(this.s.controls&&this.$items.length>1&&(d='<div class="lg-actions"><div class="lg-prev lg-icon">'+this.s.prevHtml+'</div><div class="lg-next lg-icon">'+this.s.nextHtml+"</div></div>"),".lg-sub-html"===this.s.appendSubHtmlTo&&(f='<div class="lg-sub-html"></div>'),b='<div class="lg-outer '+this.s.addClass+" "+this.s.startClass+'"><div class="lg" style="width:'+this.s.width+"; height:"+this.s.height+'"><div class="lg-inner">'+c+'</div><div class="lg-toolbar lg-group"><span class="lg-close lg-icon"></span></div>'+d+f+"</div></div>",a("body").append(b),this.$outer=a(".lg-outer"),this.$slide=this.$outer.find(".lg-item"),this.s.useLeft?(this.$outer.addClass("lg-use-left"),this.s.mode="lg-slide"):this.$outer.addClass("lg-use-css3"),g.setTop(),a(window).on("resize.lg orientationchange.lg",function(){setTimeout(function(){g.setTop()},100)}),this.$slide.eq(this.index).addClass("lg-current"),this.doCss()?this.$outer.addClass("lg-css3"):(this.$outer.addClass("lg-css"),this.s.speed=0),this.$outer.addClass(this.s.mode),this.s.enableDrag&&this.$items.length>1&&this.$outer.addClass("lg-grab"),this.s.showAfterLoad&&this.$outer.addClass("lg-show-after-load"),this.doCss()){var h=this.$outer.find(".lg-inner");h.css("transition-timing-function",this.s.cssEasing),h.css("transition-duration",this.s.speed+"ms")}setTimeout(function(){a(".lg-backdrop").addClass("in")}),setTimeout(function(){g.$outer.addClass("lg-visible")},this.s.backdropDuration),this.s.download&&this.$outer.find(".lg-toolbar").append('<a id="lg-download" target="_blank" download class="lg-download lg-icon"></a>'),this.prevScrollTop=a(window).scrollTop()},b.prototype.setTop=function(){if("100%"!==this.s.height){var b=a(window).height(),c=(b-parseInt(this.s.height,10))/2,d=this.$outer.find(".lg");b>=parseInt(this.s.height,10)?d.css("top",c+"px"):d.css("top","0px")}},b.prototype.doCss=function(){var a=function(){var a=["transition","MozTransition","WebkitTransition","OTransition","msTransition","KhtmlTransition"],b=document.documentElement,c=0;for(c=0;c<a.length;c++)if(a[c]in b.style)return!0};return!!a()},b.prototype.isVideo=function(a,b){var c;if(c=this.s.dynamic?this.s.dynamicEl[b].html:this.$items.eq(b).attr("data-html"),!a&&c)return{html5:!0};var d=a.match(/\/\/(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=|embed\/)?([a-z0-9\-\_\%]+)/i),e=a.match(/\/\/(?:www\.)?vimeo.com\/([0-9a-z\-_]+)/i),f=a.match(/\/\/(?:www\.)?dai.ly\/([0-9a-z\-_]+)/i),g=a.match(/\/\/(?:www\.)?(?:vk\.com|vkontakte\.ru)\/(?:video_ext\.php\?)(.*)/i);return d?{youtube:d}:e?{vimeo:e}:f?{dailymotion:f}:g?{vk:g}:void 0},b.prototype.counter=function(){this.s.counter&&a(this.s.appendCounterTo).append('<div id="lg-counter"><span id="lg-counter-current">'+(parseInt(this.index,10)+1)+'</span> / <span id="lg-counter-all">'+this.$items.length+"</span></div>")},b.prototype.addHtml=function(b){var c,d,e=null;if(this.s.dynamic?this.s.dynamicEl[b].subHtmlUrl?c=this.s.dynamicEl[b].subHtmlUrl:e=this.s.dynamicEl[b].subHtml:(d=this.$items.eq(b),d.attr("data-sub-html-url")?c=d.attr("data-sub-html-url"):(e=d.attr("data-sub-html"),this.s.getCaptionFromTitleOrAlt&&!e&&(e=d.attr("title")||d.find("img").first().attr("alt")))),!c)if("undefined"!=typeof e&&null!==e){var f=e.substring(0,1);"."!==f&&"#"!==f||(e=this.s.subHtmlSelectorRelative&&!this.s.dynamic?d.find(e).html():a(e).html())}else e="";".lg-sub-html"===this.s.appendSubHtmlTo?c?this.$outer.find(this.s.appendSubHtmlTo).load(c):this.$outer.find(this.s.appendSubHtmlTo).html(e):c?this.$slide.eq(b).load(c):this.$slide.eq(b).append(e),"undefined"!=typeof e&&null!==e&&(""===e?this.$outer.find(this.s.appendSubHtmlTo).addClass("lg-empty-html"):this.$outer.find(this.s.appendSubHtmlTo).removeClass("lg-empty-html")),this.$el.trigger("onAfterAppendSubHtml.lg",[b])},b.prototype.preload=function(a){var b=1,c=1;for(b=1;b<=this.s.preload&&!(b>=this.$items.length-a);b++)this.loadContent(a+b,!1,0);for(c=1;c<=this.s.preload&&!(a-c<0);c++)this.loadContent(a-c,!1,0)},b.prototype.loadContent=function(b,c,d){var e,f,g,h,i,j,k=this,l=!1,m=function(b){for(var c=[],d=[],e=0;e<b.length;e++){var g=b[e].split(" ");""===g[0]&&g.splice(0,1),d.push(g[0]),c.push(g[1])}for(var h=a(window).width(),i=0;i<c.length;i++)if(parseInt(c[i],10)>h){f=d[i];break}};if(k.s.dynamic){if(k.s.dynamicEl[b].poster&&(l=!0,g=k.s.dynamicEl[b].poster),j=k.s.dynamicEl[b].html,f=k.s.dynamicEl[b].src,k.s.dynamicEl[b].responsive){var n=k.s.dynamicEl[b].responsive.split(",");m(n)}h=k.s.dynamicEl[b].srcset,i=k.s.dynamicEl[b].sizes}else{if(k.$items.eq(b).attr("data-poster")&&(l=!0,g=k.$items.eq(b).attr("data-poster")),j=k.$items.eq(b).attr("data-html"),f=k.$items.eq(b).attr("href")||k.$items.eq(b).attr("data-src"),k.$items.eq(b).attr("data-responsive")){var o=k.$items.eq(b).attr("data-responsive").split(",");m(o)}h=k.$items.eq(b).attr("data-srcset"),i=k.$items.eq(b).attr("data-sizes")}var p=!1;k.s.dynamic?k.s.dynamicEl[b].iframe&&(p=!0):"true"===k.$items.eq(b).attr("data-iframe")&&(p=!0);var q=k.isVideo(f,b);if(!k.$slide.eq(b).hasClass("lg-loaded")){if(p)k.$slide.eq(b).prepend('<div class="lg-video-cont" style="max-width:'+k.s.iframeMaxWidth+'"><div class="lg-video"><iframe class="lg-object" frameborder="0" src="'+f+'"  allowfullscreen="true"></iframe></div></div>');else if(l){var r="";r=q&&q.youtube?"lg-has-youtube":q&&q.vimeo?"lg-has-vimeo":"lg-has-html5",k.$slide.eq(b).prepend('<div class="lg-video-cont '+r+' "><div class="lg-video"><span class="lg-video-play"></span><img class="lg-object lg-has-poster" src="'+g+'" /></div></div>')}else q?(k.$slide.eq(b).prepend('<div class="lg-video-cont "><div class="lg-video"></div></div>'),k.$el.trigger("hasVideo.lg",[b,f,j])):k.$slide.eq(b).prepend('<div class="lg-img-wrap"><img class="lg-object lg-image" src="'+f+'" /></div>');if(k.$el.trigger("onAferAppendSlide.lg",[b]),e=k.$slide.eq(b).find(".lg-object"),i&&e.attr("sizes",i),h){e.attr("srcset",h);try{picturefill({elements:[e[0]]})}catch(a){console.warn("lightGallery :- If you want srcset to be supported for older browser please include picturefil version 2 javascript library in your document.")}}".lg-sub-html"!==this.s.appendSubHtmlTo&&k.addHtml(b),k.$slide.eq(b).addClass("lg-loaded")}k.$slide.eq(b).find(".lg-object").on("load.lg error.lg",function(){var c=0;d&&!a("body").hasClass("lg-from-hash")&&(c=d),setTimeout(function(){k.$slide.eq(b).addClass("lg-complete"),k.$el.trigger("onSlideItemLoad.lg",[b,d||0])},c)}),q&&q.html5&&!l&&k.$slide.eq(b).addClass("lg-complete"),c===!0&&(k.$slide.eq(b).hasClass("lg-complete")?k.preload(b):k.$slide.eq(b).find(".lg-object").on("load.lg error.lg",function(){k.preload(b)}))},b.prototype.slide=function(b,c,d,e){var f=this.$outer.find(".lg-current").index(),g=this;if(!g.lGalleryOn||f!==b){var h=this.$slide.length,i=g.lGalleryOn?this.s.speed:0;if(!g.lgBusy){if(this.s.download){var j;j=g.s.dynamic?g.s.dynamicEl[b].downloadUrl!==!1&&(g.s.dynamicEl[b].downloadUrl||g.s.dynamicEl[b].src):"false"!==g.$items.eq(b).attr("data-download-url")&&(g.$items.eq(b).attr("data-download-url")||g.$items.eq(b).attr("href")||g.$items.eq(b).attr("data-src")),j?(a("#lg-download").attr("href",j),g.$outer.removeClass("lg-hide-download")):g.$outer.addClass("lg-hide-download")}if(this.$el.trigger("onBeforeSlide.lg",[f,b,c,d]),g.lgBusy=!0,clearTimeout(g.hideBartimeout),".lg-sub-html"===this.s.appendSubHtmlTo&&setTimeout(function(){g.addHtml(b)},i),this.arrowDisable(b),e||(b<f?e="prev":b>f&&(e="next")),c){this.$slide.removeClass("lg-prev-slide lg-current lg-next-slide");var k,l;h>2?(k=b-1,l=b+1,0===b&&f===h-1?(l=0,k=h-1):b===h-1&&0===f&&(l=0,k=h-1)):(k=0,l=1),"prev"===e?g.$slide.eq(l).addClass("lg-next-slide"):g.$slide.eq(k).addClass("lg-prev-slide"),g.$slide.eq(b).addClass("lg-current")}else g.$outer.addClass("lg-no-trans"),this.$slide.removeClass("lg-prev-slide lg-next-slide"),"prev"===e?(this.$slide.eq(b).addClass("lg-prev-slide"),this.$slide.eq(f).addClass("lg-next-slide")):(this.$slide.eq(b).addClass("lg-next-slide"),this.$slide.eq(f).addClass("lg-prev-slide")),setTimeout(function(){g.$slide.removeClass("lg-current"),g.$slide.eq(b).addClass("lg-current"),g.$outer.removeClass("lg-no-trans")},50);g.lGalleryOn?(setTimeout(function(){g.loadContent(b,!0,0)},this.s.speed+50),setTimeout(function(){g.lgBusy=!1,g.$el.trigger("onAfterSlide.lg",[f,b,c,d])},this.s.speed)):(g.loadContent(b,!0,g.s.backdropDuration),g.lgBusy=!1,g.$el.trigger("onAfterSlide.lg",[f,b,c,d])),g.lGalleryOn=!0,this.s.counter&&a("#lg-counter-current").text(b+1)}}},b.prototype.goToNextSlide=function(a){var b=this,c=b.s.loop;a&&b.$slide.length<3&&(c=!1),b.lgBusy||(b.index+1<b.$slide.length?(b.index++,b.$el.trigger("onBeforeNextSlide.lg",[b.index]),b.slide(b.index,a,!1,"next")):c?(b.index=0,b.$el.trigger("onBeforeNextSlide.lg",[b.index]),b.slide(b.index,a,!1,"next")):b.s.slideEndAnimatoin&&!a&&(b.$outer.addClass("lg-right-end"),setTimeout(function(){b.$outer.removeClass("lg-right-end")},400)))},b.prototype.goToPrevSlide=function(a){var b=this,c=b.s.loop;a&&b.$slide.length<3&&(c=!1),b.lgBusy||(b.index>0?(b.index--,b.$el.trigger("onBeforePrevSlide.lg",[b.index,a]),b.slide(b.index,a,!1,"prev")):c?(b.index=b.$items.length-1,b.$el.trigger("onBeforePrevSlide.lg",[b.index,a]),b.slide(b.index,a,!1,"prev")):b.s.slideEndAnimatoin&&!a&&(b.$outer.addClass("lg-left-end"),setTimeout(function(){b.$outer.removeClass("lg-left-end")},400)))},b.prototype.keyPress=function(){var b=this;this.$items.length>1&&a(window).on("keyup.lg",function(a){b.$items.length>1&&(37===a.keyCode&&(a.preventDefault(),b.goToPrevSlide()),39===a.keyCode&&(a.preventDefault(),b.goToNextSlide()))}),a(window).on("keydown.lg",function(a){b.s.escKey===!0&&27===a.keyCode&&(a.preventDefault(),b.$outer.hasClass("lg-thumb-open")?b.$outer.removeClass("lg-thumb-open"):b.destroy())})},b.prototype.arrow=function(){var a=this;this.$outer.find(".lg-prev").on("click.lg",function(){a.goToPrevSlide()}),this.$outer.find(".lg-next").on("click.lg",function(){a.goToNextSlide()})},b.prototype.arrowDisable=function(a){!this.s.loop&&this.s.hideControlOnEnd&&(a+1<this.$slide.length?this.$outer.find(".lg-next").removeAttr("disabled").removeClass("disabled"):this.$outer.find(".lg-next").attr("disabled","disabled").addClass("disabled"),a>0?this.$outer.find(".lg-prev").removeAttr("disabled").removeClass("disabled"):this.$outer.find(".lg-prev").attr("disabled","disabled").addClass("disabled"))},b.prototype.setTranslate=function(a,b,c){this.s.useLeft?a.css("left",b):a.css({transform:"translate3d("+b+"px, "+c+"px, 0px)"})},b.prototype.touchMove=function(b,c){var d=c-b;Math.abs(d)>15&&(this.$outer.addClass("lg-dragging"),this.setTranslate(this.$slide.eq(this.index),d,0),this.setTranslate(a(".lg-prev-slide"),-this.$slide.eq(this.index).width()+d,0),this.setTranslate(a(".lg-next-slide"),this.$slide.eq(this.index).width()+d,0))},b.prototype.touchEnd=function(a){var b=this;"lg-slide"!==b.s.mode&&b.$outer.addClass("lg-slide"),this.$slide.not(".lg-current, .lg-prev-slide, .lg-next-slide").css("opacity","0"),setTimeout(function(){b.$outer.removeClass("lg-dragging"),a<0&&Math.abs(a)>b.s.swipeThreshold?b.goToNextSlide(!0):a>0&&Math.abs(a)>b.s.swipeThreshold?b.goToPrevSlide(!0):Math.abs(a)<5&&b.$el.trigger("onSlideClick.lg"),b.$slide.removeAttr("style")}),setTimeout(function(){b.$outer.hasClass("lg-dragging")||"lg-slide"===b.s.mode||b.$outer.removeClass("lg-slide")},b.s.speed+100)},b.prototype.enableSwipe=function(){var a=this,b=0,c=0,d=!1;a.s.enableSwipe&&a.isTouch&&a.doCss()&&(a.$slide.on("touchstart.lg",function(c){a.$outer.hasClass("lg-zoomed")||a.lgBusy||(c.preventDefault(),a.manageSwipeClass(),b=c.originalEvent.targetTouches[0].pageX)}),a.$slide.on("touchmove.lg",function(e){a.$outer.hasClass("lg-zoomed")||(e.preventDefault(),c=e.originalEvent.targetTouches[0].pageX,a.touchMove(b,c),d=!0)}),a.$slide.on("touchend.lg",function(){a.$outer.hasClass("lg-zoomed")||(d?(d=!1,a.touchEnd(c-b)):a.$el.trigger("onSlideClick.lg"))}))},b.prototype.enableDrag=function(){var b=this,c=0,d=0,e=!1,f=!1;b.s.enableDrag&&!b.isTouch&&b.doCss()&&(b.$slide.on("mousedown.lg",function(d){b.$outer.hasClass("lg-zoomed")||(a(d.target).hasClass("lg-object")||a(d.target).hasClass("lg-video-play"))&&(d.preventDefault(),b.lgBusy||(b.manageSwipeClass(),c=d.pageX,e=!0,b.$outer.scrollLeft+=1,b.$outer.scrollLeft-=1,b.$outer.removeClass("lg-grab").addClass("lg-grabbing"),b.$el.trigger("onDragstart.lg")))}),a(window).on("mousemove.lg",function(a){e&&(f=!0,d=a.pageX,b.touchMove(c,d),b.$el.trigger("onDragmove.lg"))}),a(window).on("mouseup.lg",function(g){f?(f=!1,b.touchEnd(d-c),b.$el.trigger("onDragend.lg")):(a(g.target).hasClass("lg-object")||a(g.target).hasClass("lg-video-play"))&&b.$el.trigger("onSlideClick.lg"),e&&(e=!1,b.$outer.removeClass("lg-grabbing").addClass("lg-grab"))}))},b.prototype.manageSwipeClass=function(){var a=this.index+1,b=this.index-1;this.s.loop&&this.$slide.length>2&&(0===this.index?b=this.$slide.length-1:this.index===this.$slide.length-1&&(a=0)),this.$slide.removeClass("lg-next-slide lg-prev-slide"),b>-1&&this.$slide.eq(b).addClass("lg-prev-slide"),this.$slide.eq(a).addClass("lg-next-slide")},b.prototype.mousewheel=function(){var a=this;a.$outer.on("mousewheel.lg",function(b){b.deltaY&&(b.deltaY>0?a.goToPrevSlide():a.goToNextSlide(),b.preventDefault())})},b.prototype.closeGallery=function(){var b=this,c=!1;this.$outer.find(".lg-close").on("click.lg",function(){b.destroy()}),b.s.closable&&(b.$outer.on("mousedown.lg",function(b){c=!!(a(b.target).is(".lg-outer")||a(b.target).is(".lg-item ")||a(b.target).is(".lg-img-wrap"))}),b.$outer.on("mouseup.lg",function(d){(a(d.target).is(".lg-outer")||a(d.target).is(".lg-item ")||a(d.target).is(".lg-img-wrap")&&c)&&(b.$outer.hasClass("lg-dragging")||b.destroy())}))},b.prototype.destroy=function(b){var c=this;b||(c.$el.trigger("onBeforeClose.lg"),a(window).scrollTop(c.prevScrollTop)),b&&(c.s.dynamic||this.$items.off("click.lg click.lgcustom"),a.removeData(c.el,"lightGallery")),this.$el.off(".lg.tm"),a.each(a.fn.lightGallery.modules,function(a){c.modules[a]&&c.modules[a].destroy()}),this.lGalleryOn=!1,clearTimeout(c.hideBartimeout),this.hideBartimeout=!1,a(window).off(".lg"),a("body").removeClass("lg-on lg-from-hash"),c.$outer&&c.$outer.removeClass("lg-visible"),a(".lg-backdrop").removeClass("in"),setTimeout(function(){c.$outer&&c.$outer.remove(),a(".lg-backdrop").remove(),b||c.$el.trigger("onCloseAfter.lg")},c.s.backdropDuration+50)},a.fn.lightGallery=function(c){return this.each(function(){if(a.data(this,"lightGallery"))try{a(this).data("lightGallery").init()}catch(a){console.error("lightGallery has not initiated properly")}else a.data(this,"lightGallery",new b(this,c))})},a.fn.lightGallery.modules={}}()});
/*! lg-fullscreen - v1.0.0 - 2016-09-20
* http://sachinchoolur.github.io/lightGallery
* Copyright (c) 2016 Sachin N; Licensed GPLv3 */
!function(a,b){"function"==typeof define&&define.amd?define([],function(){return b()}):"object"==typeof exports?module.exports=b():b()}(this,function(){!function(a,b,c,d){"use strict";var e={fullScreen:!0},f=function(b){return this.core=a(b).data("lightGallery"),this.$el=a(b),this.core.s=a.extend({},e,this.core.s),this.init(),this};f.prototype.init=function(){var a="";if(this.core.s.fullScreen){if(!(c.fullscreenEnabled||c.webkitFullscreenEnabled||c.mozFullScreenEnabled||c.msFullscreenEnabled))return;a='<span class="lg-fullscreen lg-icon"></span>',this.core.$outer.find(".lg-toolbar").append(a),this.fullScreen()}},f.prototype.requestFullscreen=function(){var a=c.documentElement;a.requestFullscreen?a.requestFullscreen():a.msRequestFullscreen?a.msRequestFullscreen():a.mozRequestFullScreen?a.mozRequestFullScreen():a.webkitRequestFullscreen&&a.webkitRequestFullscreen()},f.prototype.exitFullscreen=function(){c.exitFullscreen?c.exitFullscreen():c.msExitFullscreen?c.msExitFullscreen():c.mozCancelFullScreen?c.mozCancelFullScreen():c.webkitExitFullscreen&&c.webkitExitFullscreen()},f.prototype.fullScreen=function(){var b=this;a(c).on("fullscreenchange.lg webkitfullscreenchange.lg mozfullscreenchange.lg MSFullscreenChange.lg",function(){b.core.$outer.toggleClass("lg-fullscreen-on")}),this.core.$outer.find(".lg-fullscreen").on("click.lg",function(){c.fullscreenElement||c.mozFullScreenElement||c.webkitFullscreenElement||c.msFullscreenElement?b.exitFullscreen():b.requestFullscreen()})},f.prototype.destroy=function(){this.exitFullscreen(),a(c).off("fullscreenchange.lg webkitfullscreenchange.lg mozfullscreenchange.lg MSFullscreenChange.lg")},a.fn.lightGallery.modules.fullscreen=f}(jQuery,window,document)});
/*! lg-thumbnail - v1.0.3 - 2017-02-05
* http://sachinchoolur.github.io/lightGallery
* Copyright (c) 2017 Sachin N; Licensed GPLv3 */
!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(this,function(a){!function(){"use strict";var b={thumbnail:!0,animateThumb:!0,currentPagerPosition:"middle",thumbWidth:100,thumbContHeight:100,thumbMargin:5,exThumbImage:!1,showThumbByDefault:!0,toogleThumb:!0,pullCaptionUp:!0,enableThumbDrag:!0,enableThumbSwipe:!0,swipeThreshold:50,loadYoutubeThumbnail:!0,youtubeThumbSize:1,loadVimeoThumbnail:!0,vimeoThumbSize:"thumbnail_small",loadDailymotionThumbnail:!0},c=function(c){return this.core=a(c).data("lightGallery"),this.core.s=a.extend({},b,this.core.s),this.$el=a(c),this.$thumbOuter=null,this.thumbOuterWidth=0,this.thumbTotalWidth=this.core.$items.length*(this.core.s.thumbWidth+this.core.s.thumbMargin),this.thumbIndex=this.core.index,this.left=0,this.init(),this};c.prototype.init=function(){var a=this;this.core.s.thumbnail&&this.core.$items.length>1&&(this.core.s.showThumbByDefault&&setTimeout(function(){a.core.$outer.addClass("lg-thumb-open")},700),this.core.s.pullCaptionUp&&this.core.$outer.addClass("lg-pull-caption-up"),this.build(),this.core.s.animateThumb?(this.core.s.enableThumbDrag&&!this.core.isTouch&&this.core.doCss()&&this.enableThumbDrag(),this.core.s.enableThumbSwipe&&this.core.isTouch&&this.core.doCss()&&this.enableThumbSwipe(),this.thumbClickable=!1):this.thumbClickable=!0,this.toogle(),this.thumbkeyPress())},c.prototype.build=function(){function b(a,b,c){var g,h=d.core.isVideo(a,c)||{},i="";h.youtube||h.vimeo||h.dailymotion?h.youtube?g=d.core.s.loadYoutubeThumbnail?"//img.youtube.com/vi/"+h.youtube[1]+"/"+d.core.s.youtubeThumbSize+".jpg":b:h.vimeo?d.core.s.loadVimeoThumbnail?(g="//i.vimeocdn.com/video/error_"+f+".jpg",i=h.vimeo[1]):g=b:h.dailymotion&&(g=d.core.s.loadDailymotionThumbnail?"//www.dailymotion.com/thumbnail/video/"+h.dailymotion[1]:b):g=b,e+='<div data-vimeo-id="'+i+'" class="lg-thumb-item" style="width:'+d.core.s.thumbWidth+"px; margin-right: "+d.core.s.thumbMargin+'px"><img src="'+g+'" /></div>',i=""}var c,d=this,e="",f="",g='<div class="lg-thumb-outer"><div class="lg-thumb lg-group"></div></div>';switch(this.core.s.vimeoThumbSize){case"thumbnail_large":f="640";break;case"thumbnail_medium":f="200x150";break;case"thumbnail_small":f="100x75"}if(d.core.$outer.addClass("lg-has-thumb"),d.core.$outer.find(".lg").append(g),d.$thumbOuter=d.core.$outer.find(".lg-thumb-outer"),d.thumbOuterWidth=d.$thumbOuter.width(),d.core.s.animateThumb&&d.core.$outer.find(".lg-thumb").css({width:d.thumbTotalWidth+"px",position:"relative"}),this.core.s.animateThumb&&d.$thumbOuter.css("height",d.core.s.thumbContHeight+"px"),d.core.s.dynamic)for(var h=0;h<d.core.s.dynamicEl.length;h++)b(d.core.s.dynamicEl[h].src,d.core.s.dynamicEl[h].thumb,h);else d.core.$items.each(function(c){d.core.s.exThumbImage?b(a(this).attr("href")||a(this).attr("data-src"),a(this).attr(d.core.s.exThumbImage),c):b(a(this).attr("href")||a(this).attr("data-src"),a(this).find("img").attr("src"),c)});d.core.$outer.find(".lg-thumb").html(e),c=d.core.$outer.find(".lg-thumb-item"),c.each(function(){var b=a(this),c=b.attr("data-vimeo-id");c&&a.getJSON("//www.vimeo.com/api/v2/video/"+c+".json?callback=?",{format:"json"},function(a){b.find("img").attr("src",a[0][d.core.s.vimeoThumbSize])})}),c.eq(d.core.index).addClass("active"),d.core.$el.on("onBeforeSlide.lg.tm",function(){c.removeClass("active"),c.eq(d.core.index).addClass("active")}),c.on("click.lg touchend.lg",function(){var b=a(this);setTimeout(function(){(d.thumbClickable&&!d.core.lgBusy||!d.core.doCss())&&(d.core.index=b.index(),d.core.slide(d.core.index,!1,!0,!1))},50)}),d.core.$el.on("onBeforeSlide.lg.tm",function(){d.animateThumb(d.core.index)}),a(window).on("resize.lg.thumb orientationchange.lg.thumb",function(){setTimeout(function(){d.animateThumb(d.core.index),d.thumbOuterWidth=d.$thumbOuter.width()},200)})},c.prototype.setTranslate=function(a){this.core.$outer.find(".lg-thumb").css({transform:"translate3d(-"+a+"px, 0px, 0px)"})},c.prototype.animateThumb=function(a){var b=this.core.$outer.find(".lg-thumb");if(this.core.s.animateThumb){var c;switch(this.core.s.currentPagerPosition){case"left":c=0;break;case"middle":c=this.thumbOuterWidth/2-this.core.s.thumbWidth/2;break;case"right":c=this.thumbOuterWidth-this.core.s.thumbWidth}this.left=(this.core.s.thumbWidth+this.core.s.thumbMargin)*a-1-c,this.left>this.thumbTotalWidth-this.thumbOuterWidth&&(this.left=this.thumbTotalWidth-this.thumbOuterWidth),this.left<0&&(this.left=0),this.core.lGalleryOn?(b.hasClass("on")||this.core.$outer.find(".lg-thumb").css("transition-duration",this.core.s.speed+"ms"),this.core.doCss()||b.animate({left:-this.left+"px"},this.core.s.speed)):this.core.doCss()||b.css("left",-this.left+"px"),this.setTranslate(this.left)}},c.prototype.enableThumbDrag=function(){var b=this,c=0,d=0,e=!1,f=!1,g=0;b.$thumbOuter.addClass("lg-grab"),b.core.$outer.find(".lg-thumb").on("mousedown.lg.thumb",function(a){b.thumbTotalWidth>b.thumbOuterWidth&&(a.preventDefault(),c=a.pageX,e=!0,b.core.$outer.scrollLeft+=1,b.core.$outer.scrollLeft-=1,b.thumbClickable=!1,b.$thumbOuter.removeClass("lg-grab").addClass("lg-grabbing"))}),a(window).on("mousemove.lg.thumb",function(a){e&&(g=b.left,f=!0,d=a.pageX,b.$thumbOuter.addClass("lg-dragging"),g-=d-c,g>b.thumbTotalWidth-b.thumbOuterWidth&&(g=b.thumbTotalWidth-b.thumbOuterWidth),g<0&&(g=0),b.setTranslate(g))}),a(window).on("mouseup.lg.thumb",function(){f?(f=!1,b.$thumbOuter.removeClass("lg-dragging"),b.left=g,Math.abs(d-c)<b.core.s.swipeThreshold&&(b.thumbClickable=!0)):b.thumbClickable=!0,e&&(e=!1,b.$thumbOuter.removeClass("lg-grabbing").addClass("lg-grab"))})},c.prototype.enableThumbSwipe=function(){var a=this,b=0,c=0,d=!1,e=0;a.core.$outer.find(".lg-thumb").on("touchstart.lg",function(c){a.thumbTotalWidth>a.thumbOuterWidth&&(c.preventDefault(),b=c.originalEvent.targetTouches[0].pageX,a.thumbClickable=!1)}),a.core.$outer.find(".lg-thumb").on("touchmove.lg",function(f){a.thumbTotalWidth>a.thumbOuterWidth&&(f.preventDefault(),c=f.originalEvent.targetTouches[0].pageX,d=!0,a.$thumbOuter.addClass("lg-dragging"),e=a.left,e-=c-b,e>a.thumbTotalWidth-a.thumbOuterWidth&&(e=a.thumbTotalWidth-a.thumbOuterWidth),e<0&&(e=0),a.setTranslate(e))}),a.core.$outer.find(".lg-thumb").on("touchend.lg",function(){a.thumbTotalWidth>a.thumbOuterWidth&&d?(d=!1,a.$thumbOuter.removeClass("lg-dragging"),Math.abs(c-b)<a.core.s.swipeThreshold&&(a.thumbClickable=!0),a.left=e):a.thumbClickable=!0})},c.prototype.toogle=function(){var a=this;a.core.s.toogleThumb&&(a.core.$outer.addClass("lg-can-toggle"),a.$thumbOuter.append('<span class="lg-toogle-thumb lg-icon"></span>'),a.core.$outer.find(".lg-toogle-thumb").on("click.lg",function(){a.core.$outer.toggleClass("lg-thumb-open")}))},c.prototype.thumbkeyPress=function(){var b=this;a(window).on("keydown.lg.thumb",function(a){38===a.keyCode?(a.preventDefault(),b.core.$outer.addClass("lg-thumb-open")):40===a.keyCode&&(a.preventDefault(),b.core.$outer.removeClass("lg-thumb-open"))})},c.prototype.destroy=function(){this.core.s.thumbnail&&this.core.$items.length>1&&(a(window).off("resize.lg.thumb orientationchange.lg.thumb keydown.lg.thumb"),this.$thumbOuter.remove(),this.core.$outer.removeClass("lg-has-thumb"))},a.fn.lightGallery.modules.Thumbnail=c}()});
/*! lg-zoom - v1.0.4 - 2016-12-20
* http://sachinchoolur.github.io/lightGallery
* Copyright (c) 2016 Sachin N; Licensed GPLv3 */
!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(this,function(a){!function(){"use strict";var b=function(){var a=!1,b=navigator.userAgent.match(/Chrom(e|ium)\/([0-9]+)\./);return b&&parseInt(b[2],10)<54&&(a=!0),a},c={scale:1,zoom:!0,actualSize:!0,enableZoomAfter:300,useLeftForZoom:b()},d=function(b){return this.core=a(b).data("lightGallery"),this.core.s=a.extend({},c,this.core.s),this.core.s.zoom&&this.core.doCss()&&(this.init(),this.zoomabletimeout=!1,this.pageX=a(window).width()/2,this.pageY=a(window).height()/2+a(window).scrollTop()),this};d.prototype.init=function(){var b=this,c='<span id="lg-zoom-in" class="lg-icon"></span><span id="lg-zoom-out" class="lg-icon"></span>';b.core.s.actualSize&&(c+='<span id="lg-actual-size" class="lg-icon"></span>'),b.core.s.useLeftForZoom?b.core.$outer.addClass("lg-use-left-for-zoom"):b.core.$outer.addClass("lg-use-transition-for-zoom"),this.core.$outer.find(".lg-toolbar").append(c),b.core.$el.on("onSlideItemLoad.lg.tm.zoom",function(c,d,e){var f=b.core.s.enableZoomAfter+e;a("body").hasClass("lg-from-hash")&&e?f=0:a("body").removeClass("lg-from-hash"),b.zoomabletimeout=setTimeout(function(){b.core.$slide.eq(d).addClass("lg-zoomable")},f+30)});var d=1,e=function(c){var d,e,f=b.core.$outer.find(".lg-current .lg-image"),g=(a(window).width()-f.prop("offsetWidth"))/2,h=(a(window).height()-f.prop("offsetHeight"))/2+a(window).scrollTop();d=b.pageX-g,e=b.pageY-h;var i=(c-1)*d,j=(c-1)*e;f.css("transform","scale3d("+c+", "+c+", 1)").attr("data-scale",c),b.core.s.useLeftForZoom?f.parent().css({left:-i+"px",top:-j+"px"}).attr("data-x",i).attr("data-y",j):f.parent().css("transform","translate3d(-"+i+"px, -"+j+"px, 0)").attr("data-x",i).attr("data-y",j)},f=function(){d>1?b.core.$outer.addClass("lg-zoomed"):b.resetZoom(),d<1&&(d=1),e(d)},g=function(c,e,g,h){var i,j=e.prop("offsetWidth");i=b.core.s.dynamic?b.core.s.dynamicEl[g].width||e[0].naturalWidth||j:b.core.$items.eq(g).attr("data-width")||e[0].naturalWidth||j;var k;b.core.$outer.hasClass("lg-zoomed")?d=1:i>j&&(k=i/j,d=k||2),h?(b.pageX=a(window).width()/2,b.pageY=a(window).height()/2+a(window).scrollTop()):(b.pageX=c.pageX||c.originalEvent.targetTouches[0].pageX,b.pageY=c.pageY||c.originalEvent.targetTouches[0].pageY),f(),setTimeout(function(){b.core.$outer.removeClass("lg-grabbing").addClass("lg-grab")},10)},h=!1;b.core.$el.on("onAferAppendSlide.lg.tm.zoom",function(a,c){var d=b.core.$slide.eq(c).find(".lg-image");d.on("dblclick",function(a){g(a,d,c)}),d.on("touchstart",function(a){h?(clearTimeout(h),h=null,g(a,d,c)):h=setTimeout(function(){h=null},300),a.preventDefault()})}),a(window).on("resize.lg.zoom scroll.lg.zoom orientationchange.lg.zoom",function(){b.pageX=a(window).width()/2,b.pageY=a(window).height()/2+a(window).scrollTop(),e(d)}),a("#lg-zoom-out").on("click.lg",function(){b.core.$outer.find(".lg-current .lg-image").length&&(d-=b.core.s.scale,f())}),a("#lg-zoom-in").on("click.lg",function(){b.core.$outer.find(".lg-current .lg-image").length&&(d+=b.core.s.scale,f())}),a("#lg-actual-size").on("click.lg",function(a){g(a,b.core.$slide.eq(b.core.index).find(".lg-image"),b.core.index,!0)}),b.core.$el.on("onBeforeSlide.lg.tm",function(){d=1,b.resetZoom()}),b.core.isTouch||b.zoomDrag(),b.core.isTouch&&b.zoomSwipe()},d.prototype.resetZoom=function(){this.core.$outer.removeClass("lg-zoomed"),this.core.$slide.find(".lg-img-wrap").removeAttr("style data-x data-y"),this.core.$slide.find(".lg-image").removeAttr("style data-scale"),this.pageX=a(window).width()/2,this.pageY=a(window).height()/2+a(window).scrollTop()},d.prototype.zoomSwipe=function(){var a=this,b={},c={},d=!1,e=!1,f=!1;a.core.$slide.on("touchstart.lg",function(c){if(a.core.$outer.hasClass("lg-zoomed")){var d=a.core.$slide.eq(a.core.index).find(".lg-object");f=d.prop("offsetHeight")*d.attr("data-scale")>a.core.$outer.find(".lg").height(),e=d.prop("offsetWidth")*d.attr("data-scale")>a.core.$outer.find(".lg").width(),(e||f)&&(c.preventDefault(),b={x:c.originalEvent.targetTouches[0].pageX,y:c.originalEvent.targetTouches[0].pageY})}}),a.core.$slide.on("touchmove.lg",function(g){if(a.core.$outer.hasClass("lg-zoomed")){var h,i,j=a.core.$slide.eq(a.core.index).find(".lg-img-wrap");g.preventDefault(),d=!0,c={x:g.originalEvent.targetTouches[0].pageX,y:g.originalEvent.targetTouches[0].pageY},a.core.$outer.addClass("lg-zoom-dragging"),i=f?-Math.abs(j.attr("data-y"))+(c.y-b.y):-Math.abs(j.attr("data-y")),h=e?-Math.abs(j.attr("data-x"))+(c.x-b.x):-Math.abs(j.attr("data-x")),(Math.abs(c.x-b.x)>15||Math.abs(c.y-b.y)>15)&&(a.core.s.useLeftForZoom?j.css({left:h+"px",top:i+"px"}):j.css("transform","translate3d("+h+"px, "+i+"px, 0)"))}}),a.core.$slide.on("touchend.lg",function(){a.core.$outer.hasClass("lg-zoomed")&&d&&(d=!1,a.core.$outer.removeClass("lg-zoom-dragging"),a.touchendZoom(b,c,e,f))})},d.prototype.zoomDrag=function(){var b=this,c={},d={},e=!1,f=!1,g=!1,h=!1;b.core.$slide.on("mousedown.lg.zoom",function(d){var f=b.core.$slide.eq(b.core.index).find(".lg-object");h=f.prop("offsetHeight")*f.attr("data-scale")>b.core.$outer.find(".lg").height(),g=f.prop("offsetWidth")*f.attr("data-scale")>b.core.$outer.find(".lg").width(),b.core.$outer.hasClass("lg-zoomed")&&a(d.target).hasClass("lg-object")&&(g||h)&&(d.preventDefault(),c={x:d.pageX,y:d.pageY},e=!0,b.core.$outer.scrollLeft+=1,b.core.$outer.scrollLeft-=1,b.core.$outer.removeClass("lg-grab").addClass("lg-grabbing"))}),a(window).on("mousemove.lg.zoom",function(a){if(e){var i,j,k=b.core.$slide.eq(b.core.index).find(".lg-img-wrap");f=!0,d={x:a.pageX,y:a.pageY},b.core.$outer.addClass("lg-zoom-dragging"),j=h?-Math.abs(k.attr("data-y"))+(d.y-c.y):-Math.abs(k.attr("data-y")),i=g?-Math.abs(k.attr("data-x"))+(d.x-c.x):-Math.abs(k.attr("data-x")),b.core.s.useLeftForZoom?k.css({left:i+"px",top:j+"px"}):k.css("transform","translate3d("+i+"px, "+j+"px, 0)")}}),a(window).on("mouseup.lg.zoom",function(a){e&&(e=!1,b.core.$outer.removeClass("lg-zoom-dragging"),!f||c.x===d.x&&c.y===d.y||(d={x:a.pageX,y:a.pageY},b.touchendZoom(c,d,g,h)),f=!1),b.core.$outer.removeClass("lg-grabbing").addClass("lg-grab")})},d.prototype.touchendZoom=function(a,b,c,d){var e=this,f=e.core.$slide.eq(e.core.index).find(".lg-img-wrap"),g=e.core.$slide.eq(e.core.index).find(".lg-object"),h=-Math.abs(f.attr("data-x"))+(b.x-a.x),i=-Math.abs(f.attr("data-y"))+(b.y-a.y),j=(e.core.$outer.find(".lg").height()-g.prop("offsetHeight"))/2,k=Math.abs(g.prop("offsetHeight")*Math.abs(g.attr("data-scale"))-e.core.$outer.find(".lg").height()+j),l=(e.core.$outer.find(".lg").width()-g.prop("offsetWidth"))/2,m=Math.abs(g.prop("offsetWidth")*Math.abs(g.attr("data-scale"))-e.core.$outer.find(".lg").width()+l);(Math.abs(b.x-a.x)>15||Math.abs(b.y-a.y)>15)&&(d&&(i<=-k?i=-k:i>=-j&&(i=-j)),c&&(h<=-m?h=-m:h>=-l&&(h=-l)),d?f.attr("data-y",Math.abs(i)):i=-Math.abs(f.attr("data-y")),c?f.attr("data-x",Math.abs(h)):h=-Math.abs(f.attr("data-x")),e.core.s.useLeftForZoom?f.css({left:h+"px",top:i+"px"}):f.css("transform","translate3d("+h+"px, "+i+"px, 0)"))},d.prototype.destroy=function(){var b=this;b.core.$el.off(".lg.zoom"),a(window).off(".lg.zoom"),b.core.$slide.off(".lg.zoom"),b.core.$el.off(".lg.tm.zoom"),b.resetZoom(),clearTimeout(b.zoomabletimeout),b.zoomabletimeout=!1},a.fn.lightGallery.modules.zoom=d}()});
/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		// CommonJS
		factory(require('jquery'));
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}

	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}

	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}

	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		try {
			// Replace server-side written pluses with spaces.
			// If we can't decode the cookie, ignore it, it's unusable.
			// If we can't parse the cookie, ignore it, it's unusable.
			s = decodeURIComponent(s.replace(pluses, ' '));
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}

	var config = $.cookie = function (key, value, options) {

		// Write

		if (value !== undefined && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setTime(+t + days * 864e+5);
			}

			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read

		var result = key ? undefined : {};

		// To prevent the for loop in the first place assign an empty array
		// in case there are no cookies at all. Also prevents odd result when
		// calling $.cookie().
		var cookies = document.cookie ? document.cookie.split('; ') : [];

		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = parts.join('=');

			if (key && key === name) {
				// If second argument (value) is a function it's a converter...
				result = read(cookie, value);
				break;
			}

			// Prevent storing a cookie that we couldn't decode.
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) === undefined) {
			return false;
		}

		// Must not alter options, thus extending a fresh object...
		$.cookie(key, '', $.extend({}, options, { expires: -1 }));
		return !$.cookie(key);
	};

}));

METUI_FUN['head_nav_met_m1156_1']=METUI['head_nav_met_m1156_1_x']={
	name: 'head_nav_met_m1156_1',
	swiper: $('.head_nav_met_m1156_1').hasClass('slide'),
	winslide: $('.head_nav_met_m1156_1').nextAll('section:not(.not-slide),div:not(.not-slide),footer:not(.not-slide)'),
	pageset: window.location.href.indexOf('pageset=1')>0,
	IE9: navigator.userAgent.indexOf('MSIE 9.0')>0,
	IE: navigator.userAgent.indexOf('IE')>0,
	open: function(){
		if(METUI['head_nav_met_m1156_1'].find('.side-open').length>0){
			METUI['head_nav_met_m1156_1'].find('.side-open, .side-shadow').click(function(){
				if($('body').hasClass('open')){
					$('body').removeClass('open');
				}else{
					$('body').addClass('open');
				}
			});
			METUI['head_nav_met_m1156_1'].find('.nav-first').each(function(index,element){
				$(this).find('img[data-original]').lazyload({
					container: '.nav-first:eq('+index+')',
					event: 'mouseover',
					load: function(){
						if($(this).parents('ul').height()>400){
							$(this).parents('ul').addClass('scroll');
						}else{
							$(this).parents('ul').css('top',$(this).parents('ul').height()/-2+35);
						}
					}
				});
			});
			METUI['head_nav_met_m1156_1'].find('.nav-first i').click(function(){
				$(this).height(METUI['head_nav_met_m1156_1'].find('.nav-first').height());
				if($(this).parent('li').hasClass('mobile-active')){
					$(this).parent('li').removeClass('mobile-active');
				}else{
					METUI['head_nav_met_m1156_1'].find('.nav-first').removeClass('mobile-active');
					$(this).parent('li').addClass('mobile-active');
				}
			});
			METUI['head_nav_met_m1156_1'].find(".modal-ewmlog img[data-original]").lazyload({
				container: '.side-phone [data-target]',
				event: 'click',
				load: function(){
					METUI['head_nav_met_m1156_1'].find('.modal-ewmlog').css('max-width', $(this)[0].width+40);
				}
			});
		}
	},
	class: function(){
		this.winslide.each(function(index,element){
			that=$(this);
			m_class=that.attr('class').split(' ');
			for(var i in m_class){
				if(m_class[i].indexOf('_met_')>0){
					that.attr('m-class',m_class[i]);
					break;
				}
			}
		});
	},
	html: function(){
		if(METUI['head_nav_met_m1156_1'].find('.sign-ul .sign-li').length==0){
			this.winslide.each(function(index,element){
				that=$(this);
				m_id=that.attr('m-id');
				that.attr('data-hash','_'+m_id);
				m_id=m_id?'m-id="'+m_id+'"':'';
				m_title=that.attr('data-title');
				m_title=m_title?'<a title="'+m_title+'"><b>'+m_title+'</b><i></i></a>':'';
				METUI['head_nav_met_m1156_1'].find('.sign-ul').append('<li class="sign-li sign '+(index?'':'active')+'" '+m_id+'>'+m_title+'</li>');
			});
		}
		if(this.swiper){
			var window_height=$(window).height();
			var window_html='<div class="window-box" style="height:'+window_height+'px;"><div class="window-wrapper">';
			this.winslide.each(function(e,i){
				if($(this).css('position')!='absolute'&&$(this).css('position')!='fixed'&&$(this).css('display')!='none'){
					$(this).addClass('window-slide').css('max-height',window_height);
					$(this).append('<div class="window-next">SCROLL</div>');
					window_html+=$(this)[0].outerHTML.replace(/data-original/g,'data-src').replace(/imgloading/g,'lazy');
					$(this).remove();
				}
			});
			window_html+='</div></div>';
			METUI['head_nav_met_m1156_1'].after(window_html);
		}
	},
	resize: function(res){
		var sidemargin=METUI['head_nav_met_m1156_1'].find('.side-box').outerHeight()-
			METUI['head_nav_met_m1156_1'].find('.side-foot').outerHeight()-
			METUI['head_nav_met_m1156_1'].find('.side-nav').outerHeight()-
			METUI['head_nav_met_m1156_1'].find('.side-user').outerHeight()-
			METUI['head_nav_met_m1156_1'].find('.side-search').outerHeight();
		sidemargin=sidemargin<0?0:sidemargin;
		METUI['head_nav_met_m1156_1'].find('.side-nav').css('margin-bottom',sidemargin);
		var signWidth=[], sign_all_width=0, sign_width=0, sign_num_width=0;
		METUI['head_nav_met_m1156_1'].find('.sign-box .sign-li').each(function(index){
			signWidth[index]=$(this).width();
			sign_all_width+=signWidth[index];
		});
		var sign_width=METUI['head_nav_met_m1156_1'].find('.side-head').width()-METUI['head_nav_met_m1156_1'].find('.side-logo').width();
		sign_width=sign_width>sign_all_width?sign_all_width:sign_width;
		METUI['head_nav_met_m1156_1'].find('.sign-box').width(sign_width);
		sign_num_width=0;
		for(var i=0;i<30;i++){
			if(sign_num_width+signWidth[i]<=sign_width){
				sign_num_width+=signWidth[i];
			}
		}
		if(!res){
			window.setTimeout(function(){
				METUI['head_nav_met_m1156_1_sign']=new Swiper('.sign-box',{
					wrapperClass: 'sign-ul',
					slideClass: 'sign-li',
					slidesPerView: 'auto',
					mousewheelControl: true,
					observer:true,
					observeParents: true,
					slidesOffsetBefore: sign_width-sign_num_width,
					onTap: function(swiper){
						if(METUI['head_nav_met_m1156_1'].find('.sign-li.sign').length>0){
							METUI['head_nav_met_m1156_1'].find('.sign-li').removeClass('active').eq(swiper.clickedIndex).addClass('active');
							if(METUI['head_nav_met_m1156_1_x'].swiper){
								METUI['slide'].slideTo(swiper.clickedIndex);
							}else{
								$('html,body').animate({
									scrollTop:
									$('[data-title="'+METUI['head_nav_met_m1156_1'].find('.sign-li').eq(swiper.clickedIndex).find('b').text()+'"]').offset().top
								});
							}
						}
					}
				});
			},3);
			METUI['head_nav_met_m1156_1'].find(".side-logo img[data-original]").lazyload({
				load: function(){ 
					METUI['head_nav_met_m1156_1_x'].resize(true);
				}
			});
			$(window).resize(function(){ 
				METUI['head_nav_met_m1156_1_x'].resize(true);
			});
		}else{
			window.setTimeout(function(){
				if(METUI['head_nav_met_m1156_1'].find('.sign-box').length>0){
					METUI['head_nav_met_m1156_1_sign'].params.slidesOffsetBefore=sign_width-sign_num_width;
					METUI['head_nav_met_m1156_1_sign'].update(true);
					METUI['head_nav_met_m1156_1_sign'].slideTo(METUI['head_nav_met_m1156_1'].find('.sign-li.active').index());
				}
			},4);
		}
	},
	slide: function(){
		if(METUI['head_nav_met_m1156_1_x'].swiper){
			METUI['slide_time']=window.setTimeout(function(){
				METUI['slide']=new Swiper('.head_nav_met_m1156_1 + .window-box',{
					wrapperClass: 'window-wrapper',
					slideClass: 'window-slide',
					slideActiveClass: 'now',
					slideVisibleClass: 'visible',
					lazyLoadingClass: 'lazy',
					slidePrevClass: 'prev',
					slideNextClass: 'next',
					direction: 'vertical',
					hashnav: true,
					lazyLoading: true,
					lazyLoadingOnTransitionStart: true,
					watchSlidesProgress: true,
					watchSlidesVisibility: true,
					roundLengths: true, 
					keyboardControl: true,
					slidesPerView: 'auto',
					runCallbacksOnInit: false,
					uniqueNavElements :false,
					mousewheelControl: true,
					simulateTouch: false,
					longSwipesRatio: .3,
					touchAngle: 30,
					nextButton: '.head_nav_met_m1156_1 + .window-box .window-next',
					observer: true,
					onInit: function(swiper){	  
						swiper.slides.each(function(){
							that=$(this);
							id=that.attr('m-class');
							if(that.hasClass('visible')){
								if(!that.hasClass('pass')){
									that.addClass('pass');
									METUI['head_nav_met_m1156_1_x'].fun(id,1);
								}else{
									METUI['head_nav_met_m1156_1_x'].fun(id,2);
								}
								that.removeClass('over');
							}else{
								if(that.hasClass('pass')&&!that.hasClass('over')){
									METUI['head_nav_met_m1156_1_x'].fun(id,3);
									that.addClass('over');
									if(that.height()<$(window).height()){
										clearTimeout(METUI['slide_time']);
										METUI['slide_time']=window.setTimeout(function(){
											swiper.update(true);
										},100);
									}
								}
							}
						});
						if(METUI['head_nav_met_m1156_1'].find('.sign-li.sign').length>0){
							window.setTimeout(function(){
								METUI['head_nav_met_m1156_1'].find('.sign-li').removeClass('active').eq(swiper.activeIndex).addClass('active');
								METUI['head_nav_met_m1156_1_sign'].slideTo(swiper.activeIndex);
							},100);
						}
						if(METUI['head_nav_met_m1156_1'].hasClass('scroll')){
							if(swiper.activeIndex==0){
								METUI['head_nav_met_m1156_1'].find('.side-head').removeClass('active');
							}else{
								METUI['head_nav_met_m1156_1'].find('.side-head').addClass('active');
							}
						}
					},
					onSlideChangeEnd: function(swiper){
						this.onInit(swiper);
					},
					onTransitionEnd: function(swiper){
						var slide=swiper.slides.eq(swiper.activeIndex);
						if(slide.height()==$(window).height()&&slide[0].scrollHeight>slide.height()&&slide.offset().top<5){
							swiper.disableTouchControl();
							swiper.disableMousewheelControl();
							if(!slide.hasClass('scroll')){
								slide.scroll(function(){
									var top=slide.scrollTop();
									if(top==0||top==slide[0].scrollHeight-slide.height()){
										swiper.enableTouchControl();
										swiper.enableMousewheelControl();
									}
								}).addClass('scroll');
							}
						}
					},
					onBeforeResize: function(swiper){
						window_height=$(window).height();
						METUI['head_nav_met_m1156_1'].next('.window-box').height(window_height);
						METUI['head_nav_met_m1156_1'].next('.window-box').find('.window-slide').css('max-height',window_height);
					}
				});
			},1);
		}
	},
	scroll: function(res){
		if(!METUI['head_nav_met_m1156_1_x'].swiper){
			var wnHeg=$(window).height();
			var scTop=$(window).scrollTop();
			if(METUI['head_nav_met_m1156_1'].hasClass('scroll')){
				if(scTop==0){
					METUI['head_nav_met_m1156_1'].find('.side-head').removeClass('active');
				}else{
					METUI['head_nav_met_m1156_1'].find('.side-head').addClass('active');
				}
			}
			METUI['head_nav_met_m1156_1_x'].winslide.each(function(){
				var that=$(this);
				if(that.css('position')!='absolute'&&that.css('position')!='fixed'&&that.css('display')!='none'){
					var uiHeg=that.height();
					var uiTop=that.offset().top;
					var uiCls=that.attr('m-class');
					if(uiTop-wnHeg<scTop&&uiTop+uiHeg>scTop){
						if(!that.hasClass('now')){
							if(!that.hasClass('new')){
								that.addClass('new');
								METUI['head_nav_met_m1156_1_x'].fun(uiCls,1);
							}else{
								METUI['head_nav_met_m1156_1_x'].fun(uiCls,2);
							}
							that.addClass('now');
						}
						that.removeClass('out');
					}else{
						if(!that.hasClass('out')){
							if(that.hasClass('new')){
								METUI['head_nav_met_m1156_1_x'].fun(uiCls,3);
							}
							that.addClass('out');
						}
						that.removeClass('now');
					}
					if(METUI['head_nav_met_m1156_1'].find('.sign-ul .sign-li.sign').length>0&&uiTop-wnHeg*4/7<scTop&&uiTop+uiHeg>scTop){
						var sign=METUI['head_nav_met_m1156_1'].find('.sign-ul .sign-li.sign a[title="'+that.attr('data-title')+'"]');
						if(sign.length>0){
							METUI['head_nav_met_m1156_1'].find('.sign-li').removeClass('active').eq(sign.parent().index()).addClass('active');
						}
					}
				}
			});
			if(!res) $(window).scroll(function(){ METUI['head_nav_met_m1156_1_x'].scroll(true); });
		}
	},
	fun: function(cls,num){
		if(cls){
			if(num==1){
				times=window.setTimeout(function(){
					try{
						METUI[cls+'_x'].slide(num);
					}catch(e){}
				},100);
			}else{
				try{
					METUI[cls+'_x'].slide(num);
				}catch(e){}
			}
		}
	},
	load: function(){
		$(window).load(function(){
			METUI['head_nav_met_m1156_1'].find(".load-box").addClass('active');
			if(!Breakpoints.is('xs')){
				$("a[href][target!='_blank']").click(function(){
					if( $(this).attr('href').indexOf('#')&&
						$(this).attr('href').indexOf('javascript:')&&
						$(this).attr('href').indexOf('tel:')&&
						!$(this).hasClass('notload')&&
						!$(this).data("events")["click"]){
						METUI['head_nav_met_m1156_1'].find('.load-box').removeClass('active');
					}
				});
			}else{
				METUI['head_nav_met_m1156_1'].find(".load-box").remove();
			}
		});
		window.setTimeout(function(){
			METUI['head_nav_met_m1156_1'].find(".load-box").addClass('active');	
		},5000);
	},
	sub: function(){		
		if($('.sign-box ol').length>0){
			$('.sign-box').addClass('active');
		}
	},
	ewm: function(){
		METUI['head_nav_met_m1156_1'].find('i.icon.fa-qrcode').click(function(){
			window.setTimeout(function(){
			  METUI['head_nav_met_m1156_1'].find(".modal-ewmlog img[data-original]").lazyload({
				  load: function(){
					  METUI['head_nav_met_m1156_1'].find('.modal-ewmlog').css('max-width', $(this)[0].width+40);
				  }
			  });
			},500);
		});	
	},
	share: function(){
		METUI['head_nav_met_m1156_1'].find('a.share').click(function(){
			window._bd_share_config={
				"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},
				"share":{}
			};
			with(document)0[
				(getElementsByTagName('head')[0]||body)
				.appendChild(createElement('script'))
				.src='//bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)
			];
		});
	},
	simplified: function(){
    	var isSimplified = true;
		METUI['head_nav_met_m1156_1'].find('.simplified').click(function() {
			if(isSimplified){
				$('body').s2t();
				isSimplified=false;
				$(this).attr('title',$(this).attr('title').replace('绻�','绠€'));
				$(this).find('i').text('绠€');
			}else{
				$('body').t2s();
				isSimplified=true;
				$(this).attr('title',$(this).attr('title').replace('绠€','绻�'));
				$(this).find('i').text('绻�');
			}
		});
	},
	music: function(){
		if( METUI['head_nav_met_m1156_1'].find('#audio').length>0){
			var audio = METUI['head_nav_met_m1156_1'].find('#audio')[0],
			canvas = METUI['head_nav_met_m1156_1'].find('#canvas')[0],
			mWidth = canvas.width,
			mHeigt = canvas.height,
			metNum = mWidth/5,
			metMax = 200,
			metWid = 4,
			oldArr = [],
			oldCur = $.cookie('currentTime')||0,
			status = $.cookie('status')||METUI['head_nav_met_m1156_1'].find('#audio').attr('status'),
			aoPath = METUI['head_nav_met_m1156_1'].find('#audio').css('backgroundImage').replace('url("','').replace('")',''),
			ctx = canvas.getContext('2d');
			step = Math.floor(1024/metNum);
			status_func(status);
			METUI['head_nav_met_m1156_1'].find('#canvas').click(function(){
				status_func(status==1?0:1);
			});
			function status_func(s){
				METUI['head_nav_met_m1156_1'].find('#audio').attr('status',s);
				$.cookie('status',s,{path:'/'});
				status=s;
				if(s==1){
					audio.play();
				}else{
					audio.pause();
					ctx.clearRect(0, 0, mWidth, mHeigt);
					ctx.fillStyle=METUI['head_nav_met_m1156_1'].find('#audio').css('color');
					if($.cookie('Fill')){
						Fill=$.cookie('Fill').split(',');
						for (i=0; i<=metNum; i++) {
							ctx.fillRect(mWidth-i*(metWid+1), mHeigt-Fill[i]-1, metWid, mHeigt); 
						}
					}
					ctx.fillStyle=METUI['head_nav_met_m1156_1'].find('#canvas').css('color').replace('rgb(','rgba(').replace(')',', 0.08)');
					ctx.fillRect(0,0,150,60);
					ctx.fillStyle=METUI['head_nav_met_m1156_1'].find('#canvas').css('color').replace('rgb(','rgba(').replace(')',', 0.38)');
					ctx.beginPath();
					ctx.moveTo(45,11);
					ctx.lineTo(58,18);
					ctx.lineTo(45,25);
					ctx.closePath();
					ctx.fill();
				}
			}
			if(status==1 && Breakpoints.is('xs')){ 
				$(document).one('touchstart',function(){
					if(oldCur>=0){
						audio.currentTime=oldCur;
						audio.play();
					}
				});
			}
			if(!Breakpoints.is('xs') && !this.IE){
				try{
					window.AudioContext = window.AudioContext||window.webkitAudioContext||window.mozAudioContext||window.msAudioContext;
					atx=new AudioContext();
					analyser=atx.createAnalyser();
					audioSrc=atx.createMediaElementSource(audio);
					audioSrc.connect(analyser);
					analyser.connect(atx.destination);
					frequencyData=new Uint8Array(analyser.frequencyBinCount);
					var Data='',Dnum=0;
					function renderFrame(){
						window.setTimeout(function(){
							renderFrame();
							if(status==1 && oldCur==-1){
								var Fill='';
								if(Data!='' && METUI['head_nav_met_m1156_1_x'].pageset) Data+='|';
								analyser.getByteFrequencyData(frequencyData);
								ctx.clearRect(0, 0, mWidth, mHeigt);
								Data+=Math.floor(audio.currentTime*20).toString(36)+'/';
								for (var i=0; i<=metNum; i++) {
									istep = frequencyData[i*step];
									if(istep>metMax) metMax=istep;
									ctx.fillStyle=METUI['head_nav_met_m1156_1'].find('#audio').css('color');
									Val=Math.floor(istep/metMax*mHeigt)
									ctx.fillRect(mWidth-i*(metWid+1), mHeigt-Val, metWid, mHeigt);
									if(METUI['head_nav_met_m1156_1_x'].pageset) Data+=Val.toString(36);
									Fill+=Val+',';
								}
								$.cookie('Fill',Fill,{path:'/'});
								if(METUI['head_nav_met_m1156_1_x'].pageset) {
									if(Dnum>100){
										$.post(aoPath+'/audio.php',{Data:Data,lang:M['lang']});
										Data='';
										Dnum=0;
									}else Dnum++;
								}
							}
						},50);
					}
					renderFrame();
				}catch(e){}
			}else{
				$.get(aoPath+"/audio_"+M['lang']+".txt",function(Bata){
						var Bata=Bata.split('|'),Data=[],Cata=0;
						for(i=0;i<Bata.length;i++){
							Vals=Bata[i].split('/');
							Data[parseInt(Vals[0],36)]=Vals[1];
						}
						function renderFrame(){
							window.setTimeout(function(){
								renderFrame();
								if(status==1 && oldCur==-1){
									if(Cata==0 || Cata%100==0){
										Cata=Math.floor(audio.currentTime*20);
									}	
									Nata=Data[Cata];							
									if(Nata){
										ctx.clearRect(0, 0, mWidth, mHeigt);
										var Fill='';
										var Pata=Nata.split('');
										for(var i=0; i<=metNum; i++){
											Val=parseInt(Pata[i],36);
											ctx.fillStyle=METUI['head_nav_met_m1156_1'].find('#audio').css('color');
											ctx.fillRect(mWidth-i*(metWid+1), mHeigt-Val, metWid, mHeigt);
											Fill+=Val+',';
										}
										$.cookie('Fill',Fill,{path:'/'});
									}
									Cata++;
								}else{
									Cata=0;
								}
							},50);
						}
						renderFrame();
				});
			}
			function oldCur_func(){
				if(this.IE){
					audio.pause();
					audio.currentTime=oldCur;
					oldCur=-1;
					audio.play();
				}else{
					audio.volume=0;
					audio.currentTime=oldCur;
					oldCur=-1;
					audio.volume=1;
				}
			}
			audio.onloadedmetadata=function(){
				oldCur_func();
			}
			audio.ontimeupdate=function(){
				if(oldCur>=0){
					oldCur_func();
				}else{
					$.cookie('currentTime',audio.currentTime,{path:'/'});
				}
			}
			audio.onended=function(){
				audio.play();
			}
		}
	}
}
var x=new metui(METUI_FUN['head_nav_met_m1156_1']);



METUI_FUN['banner_met_m1156_1']=METUI['banner_met_m1156_1_x']={
	name: 'banner_met_m1156_1',
	init: function(){
		if($('.swiper-header').length==0){
			METUI['banner_met_m1156_1_x'].slide(1);
		}
		METUI['banner_met_m1156_1'].find('font[color]').each(function(){
			$(this).css('color',$(this).attr('color'));
		});
	},
	resize: function(res){
		if(Breakpoints.is('lg')){
			METUI['banner_met_m1156_1'].find('.banner-slide ul li.pc img[data-src]').each(function(){
				$(this).attr('src',$(this).attr('data-src'));
				$(this).removeAttr('data-src');
			});
		}else if(Breakpoints.is('xs')){
			METUI['banner_met_m1156_1'].find('.banner-slide ul li.phone img[data-src]').each(function(){
				$(this).attr('src',$(this).attr('data-src'));
				$(this).removeAttr('data-src');
			});
		}else{
			METUI['banner_met_m1156_1'].find('.banner-slide ul li.pad img[data-src]').each(function(){
				$(this).attr('src',$(this).attr('data-src'));
				$(this).removeAttr('data-src');
			});
		}
		if(METUI['banner_met_m1156_1'].hasClass('full')) METUI['banner_met_m1156_1'].height($(window).height());
		if(!res) $(window).resize(function(){ METUI['banner_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(METUI['banner_met_m1156_1'].find('.banner-slide').length>1){
					METUI['banner_met_m1156_1_banner']=new Swiper('.banner_met_m1156_1 .banner-box',{
						wrapperClass: 'banner-wrapper',
						slideClass: 'banner-slide',
						slidesPerView: 1,
						simulateTouch: false,			
						speed: 500,
						loop: true,
						autoplay: 5500,
						autoplayDisableOnInteraction: true,
						autoHeight: true,
						lazyLoading: true,
						lazyLoadingClass: 'banner-lazy',
						lazyLoadingInPrevNext: true,
						observer:true,
						observeParents:true,
						watchSlidesProgress : true,
						watchSlidesVisibility : true,
						pagination: '.banner_met_m1156_1 .banner-pager',
						paginationClickable :true,
						paginationBulletRender: function (swiper, index, className) {
							return '<span class="'+className+'"><hr><hr><hr><hr></span>';
						}
					});
				}else{
					METUI['banner_met_m1156_1']
						.find('.banner-slide')
						.addClass('swiper-slide-active')
						.find('.banner-lazy')
						.css('background-image','url('+METUI['banner_met_m1156_1'].find('.banner-slide').attr('data-background')+')');
				}
				if(!METUI['slide']&&METUI['banner_met_m1156_1_banner']){
					var play=false;
					$(window).scroll(function(){
						var wnHeg=$(window).height();
						var scTop=$(window).scrollTop();
						var uiHeg=METUI['banner_met_m1156_1'].height();
						var uiTop=METUI['banner_met_m1156_1'].offset().top;
						if((uiTop-wnHeg<scTop)&&(uiTop+uiHeg>scTop)){
							if(play==false){
								play=true;
								METUI['banner_met_m1156_1_banner'].startAutoplay();
							}
						}else{
							if(play==true){
								play=false;
								METUI['banner_met_m1156_1_banner'].stopAutoplay();
							}
						}
					});
				}
			break;
			case 2:
				if(METUI['banner_met_m1156_1_banner']) METUI['banner_met_m1156_1_banner'].stopAutoplay();
			break;
			case 3:
				if(METUI['banner_met_m1156_1_banner']) METUI['banner_met_m1156_1_banner'].startAutoplay();
			break;
		}
	}
}
var x=new metui(METUI_FUN['banner_met_m1156_1']);



METUI_FUN['ad_met_m1156_1']=METUI['ad_met_m1156_1_x']={
	name: 'ad_met_m1156_1',
	init: function(){
		if($('.swiper-header').length==0){
			METUI['ad_met_m1156_1_x'].slide(1);
		}
	},
	resize: function(res){
		
		if(!res) $(window).resize(function(){ METUI['ad_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(!METUI['slide']){
					METUI['ad_met_m1156_1']
						.css('background-image','url('+METUI['ad_met_m1156_1'].attr('data-background')+')')
						.removeAttr('data-background');
				}
			break;
			case 2:
			
			break;
			case 3:
			
			break;
		}
	}
}
var x=new metui(METUI_FUN['ad_met_m1156_1']);


METUI_FUN['foot_info_met_m1156_1']=METUI['foot_info_met_m1156_1_x']={
	name: 'foot_info_met_m1156_1',
	init: function(){
		
	},
	resize: function(res){
		if(Breakpoints.is('lg')||Breakpoints.is('md')){
			var left_width=METUI['foot_info_met_m1156_1'].find('.foot-left').width();
			var right_width=METUI['foot_info_met_m1156_1'].find('.foot-right').width();
			var foot_width=METUI['foot_info_met_m1156_1'].width();
			if(left_width+right_width>foot_width){
				if(left_width>right_width){
					METUI['foot_info_met_m1156_1'].find('.foot-left').css('max-width',foot_width-right_width);
				}else{
					METUI['foot_info_met_m1156_1'].find('.foot-right').css('max-width',foot_width-left_width);
				}
			}
		}else{
			METUI['foot_info_met_m1156_1'].find('.foot-left,.foot-right').css('max-width',999999);
		}
		if(!res) $(window).resize(function(){ METUI['foot_info_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
			
			break;
			case 2:
			
			break;
			case 3:
			
			break;
		}
	},
	simplified: function(){
    	var isSimplified = true;
		METUI['foot_info_met_m1156_1'].find('.simplified').click(function() {
			if(isSimplified){
				$('body').s2t();
				isSimplified=false;
				$(this).attr('title',$(this).attr('title').replace('绻�','绠€'));
				$(this).find('i').text('绠€');
			}else{
				$('body').t2s();
				isSimplified=true;
				$(this).attr('title',$(this).attr('title').replace('绠€','绻�'));
				$(this).find('i').text('绻�');
			}
		});
	}
}
var x=new metui(METUI_FUN['foot_info_met_m1156_1']);



METUI_FUN['back_top_met_m1156_1']=METUI['back_top_met_m1156_1_x']={
	name: 'back_top_met_m1156_1',
	height: $(window).height(),
	init: function(){
		window.setTimeout(function(){
			var number=METUI['back_top_met_m1156_1'].attr('number')||1;
			if(METUI['slide']){
					METUI['slide'].on('TransitionEnd',function(swiper){
						if(-swiper.getWrapperTranslate()>=number*METUI['back_top_met_m1156_1_x'].height){
							METUI['back_top_met_m1156_1'].addClass('active');
						}else{
							METUI['back_top_met_m1156_1'].removeClass('active');
						}
					});			
					METUI['back_top_met_m1156_1'].click(function(){
						METUI['slide'].slideTo(0);
					});
			}else{
				$(window).scroll(function(){
					if($(window).scrollTop()>=number*METUI['back_top_met_m1156_1_x'].height){
						METUI['back_top_met_m1156_1'].addClass('active');
					}else{
						METUI['back_top_met_m1156_1'].removeClass('active');
					}
				});
				METUI['back_top_met_m1156_1'].click(function(){					
					$('html,body').animate({scrollTop:0});
				});
			}
		},2);
	},
	resize: function(res){
		METUI['back_top_met_m1156_1_x'].height=$(window).height();
		if(!res) $(window).resize(function(){ METUI['back_top_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		
	}
}
var x=new metui(METUI_FUN['back_top_met_m1156_1']);



METUI_FUN['banner_list_met_m1156_1']=METUI['banner_list_met_m1156_1_x']={
	name: 'banner_list_met_m1156_1',
	init: function(){
		if($('.swiper-header').length==0){
			METUI['banner_list_met_m1156_1_x'].slide(1);
		}	
	},
	resize: function(res){
		METUI['banner_list_met_m1156_1'].find('small').each(function(){
			sml=$(this).html().split('|');
			if(Breakpoints.is('lg')){
				$(this).parent('font').css('font-size',sml[0]+'px');
			}else if(Breakpoints.is('md')||Breakpoints.is('sm')){
				$(this).parent('font').css('font-size',sml[1]+'px');
			}else if(Breakpoints.is('xs')){
				$(this).parent('font').css('font-size',sml[2]+'px');
			}
		});
		METUI['banner_list_met_m1156_1'].height($(window).height());
		if(!res) $(window).resize(function(){ METUI['banner_list_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(!METUI['slide']){
					METUI['banner_list_met_m1156_1']
						.css('background-image','url('+METUI['banner_list_met_m1156_1'].attr('data-background')+')')
						.removeAttr('data-background')
				}
				if(METUI['banner_list_met_m1156_1'].find('.banner-bin').length>1){
					METUI['banner_list_met_m1156_1_index']=new Swiper('.banner_list_met_m1156_1 .banner-box',{
						wrapperClass: 'banner-cut',
						slideClass: 'banner-bin',
						slideActiveClass: 'active',
						slidePrevClass: 'prev',
						slideNextClass: 'next',
						speed: 500,
						loop: true,
						autoplay: 5500,
						autoplayDisableOnInteraction: true,
						observer:true,
						observeParents:true,
						lazyLoading: true,
						lazyLoadingClass: 'banner-lazy',
						lazyLoadingOnTransitionStart: true,
						keyboardControl: true,
						slidesPerView: 1,
						simulateTouch: false,
						pagination: '.banner_list_met_m1156_1 .banner-pager',
						paginationClickable :true,
						paginationBulletRender: function (swiper, index, className) {
							return '<span class="'+className+'"><hr><hr><hr><hr></span>';
						}
					});
				}else{
					var banner=METUI['banner_list_met_m1156_1'].find('.banner-bin');
					banner.addClass('active').css('background-image','url('+banner.attr('data-background')+')');
				}
				METUI['banner_list_met_m1156_1'].addClass('active');
			break;
			case 2:
				METUI['banner_list_met_m1156_1_index'].init();
				METUI['banner_list_met_m1156_1'].addClass('active');
			break;
			case 3:
				if(METUI['banner_list_met_m1156_1_index']) METUI['banner_list_met_m1156_1_index'].destroy(false);
				METUI['banner_list_met_m1156_1'].removeClass('active');
			break;
		}
	}
}
var x=new metui(METUI_FUN['banner_list_met_m1156_1']);



METUI_FUN['show_list_met_m1156_1']=METUI['show_list_met_m1156_1_x']={
	name: 'show_list_met_m1156_1',
	IE9: navigator.userAgent.indexOf('MSIE 9.0')>0,
	init: function(){
		if($('.swiper-header').length==0){
			METUI['show_list_met_m1156_1_x'].slide(1);
		}		
	},
	resize: function(res){
		if(METUI['show_list_met_m1156_1'].hasClass('full')) METUI['show_list_met_m1156_1'].height($(window).height());
		if(!res) $(window).resize(function(){ METUI['show_list_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(!METUI['slide']){
					METUI['show_list_met_m1156_1']
						.css('background-image','url('+METUI['show_list_met_m1156_1'].attr('data-background')+')')
						.removeAttr('data-background');
				}
				METUI['show_list_met_m1156_1_about']=new Swiper('.about-list',{ 
					wrapperClass: 'about-ul',
					slideClass: 'about-li',
					autoplay: 3500, 
					lazyLoading: true,
					lazyLoadingClass: 'about-lazy',
					lazyLoadingOnTransitionStart: true,
					watchSlidesProgress: true,
					watchSlidesVisibility: true,
					observer:true,
					observeParents:true,
					slidesPerView: this.IE9?1:'auto',
					keyboardControl: true
				});
				METUI['show_list_met_m1156_1'].addClass('active');
			break;
			case 2:
				METUI['show_list_met_m1156_1_about'].init();
				METUI['show_list_met_m1156_1'].addClass('active');
			break;
			case 3:
				if(METUI['show_list_met_m1156_1_about']) METUI['show_list_met_m1156_1_about'].destroy(false);
				METUI['show_list_met_m1156_1'].removeClass('active');
			break;
		}
	}
}
var x=new metui(METUI_FUN['show_list_met_m1156_1']);



METUI_FUN['product_list_met_m1156_1']=METUI['product_list_met_m1156_1_x']={
	name: 'product_list_met_m1156_1',
	IE9: navigator.userAgent.indexOf('MSIE 9.0')>0,
	init: function(){
		if($('.swiper-header').length==0){
			METUI['product_list_met_m1156_1_x'].slide(1);
		}	
	},
	resize: function(res){
		if(METUI['product_list_met_m1156_1'].hasClass('full')) METUI['product_list_met_m1156_1'].height($(window).height());
		if(!res) $(window).resize(function(){ METUI['product_list_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(!METUI['slide']){
					METUI['product_list_met_m1156_1']
						.css('background-image','url('+METUI['product_list_met_m1156_1'].attr('data-background')+')')
						.removeAttr('data-background');
				}
				if(METUI['product_list_met_m1156_1'].find('.picture-list').length>0){
					METUI['product_list_met_m1156_1_picture']=new Swiper('.picture-list',{
						wrapperClass: 'picture-ul',
						slideClass: 'picture-li',
						autoplay: 3500,
						lazyLoading: true,
						lazyLoadingClass: 'picture-lazy',
						lazyLoadingOnTransitionStart: true,
						observer:true,
						observeParents:true,
						watchSlidesProgress: true,
						watchSlidesVisibility: true,
						slidesPerView: this.IE9?4:'auto',
						keyboardControl: true
					});
					if(METUI['product_list_met_m1156_1'].find('.picture-list').length==1){
						var picture=METUI['product_list_met_m1156_1_picture'];
						METUI['product_list_met_m1156_1_picture']=[];
						METUI['product_list_met_m1156_1_picture'][0]=picture;
					}
					for(var i in METUI['product_list_met_m1156_1_picture']){
						METUI['product_list_met_m1156_1_picture'][i].stopAutoplay(); 
					}
					METUI['product_list_met_m1156_1_picture'][0].startAutoplay(); 
					METUI['product_list_met_m1156_1'].find('.picture-nav b').click(function(){
						METUI['product_list_met_m1156_1'].find('.picture-nav b').removeClass('active');
						$(this).addClass('active');
						METUI['product_list_met_m1156_1'].find('.picture-list').removeClass('active');
						METUI['product_list_met_m1156_1'].find('.picture-list[data-id='+$(this).attr('data-id')+']').addClass('active');
						for(var i in METUI['product_list_met_m1156_1_picture']){
							METUI['product_list_met_m1156_1_picture'][i].stopAutoplay(); 
						}
						METUI['product_list_met_m1156_1_picture'][$(this).index()].startAutoplay(); 
					});
					METUI['product_list_met_m1156_1'].find('.picture-ctrl .ctrl-left').click(function(){
						METUI['product_list_met_m1156_1_picture'][METUI['product_list_met_m1156_1'].find('.picture-list.active').index()].slidePrev();
					});
					METUI['product_list_met_m1156_1'].find('.picture-ctrl .ctrl-right').click(function(){
						METUI['product_list_met_m1156_1_picture'][METUI['product_list_met_m1156_1'].find('.picture-list.active').index()].slideNext();
					});
					METUI['product_list_met_m1156_1'].find('.picture-nav b').dblclick(function(){
						window.location.href=$(this).attr('data-href');
					});
				}
				METUI['product_list_met_m1156_1'].find('.picture-li p').click(function(){
					var imglist = $(this).data("imglist"),
						dyarr = new Array(),
						arlt = imglist.split('|');
					$.each(arlt,function(name,value){
						if(value!=''){
							var st = value.split('*'),
							key = name;
							dyarr[key] = new Array();
							dyarr[key]['src'] = st[1];
							dyarr[key]['thumb'] = st[1];
							dyarr[key]['subHtml'] = st[0];
						}
					});
					$(this).lightGallery({
						autoplayControls:false,
						getCaptionFromTitleOrAlt:false,
						dynamic: true,
						dynamicEl: dyarr,
						thumbWidth:64,
						thumbContHeight:84,
					});
					$(this).on('onSlideClick.lg',function(){
						$('.lg-outer .lg-toolbar').toggleClass('opacity0');
						if($('.lg-outer .lg-toolbar').hasClass('opacity0')){
							$('.lg-outer').removeClass('lg-thumb-open');
						}else{
							$('.lg-outer').addClass('lg-thumb-open');
						}
						if(Breakpoints.is('xs')){
							if($('.lg-outer .lg-toolbar').hasClass('opacity0')){
								$('.lg-outer .lg-actions').addClass('hide');
							}else{
								$('.lg-outer .lg-actions').removeClass('hide');
							}
						}else{
							$('.lg-outer .lg-actions').removeClass('hide');
						}
					});
				});
				METUI['product_list_met_m1156_1'].addClass('active');
			break;
			case 2:
				for(var i in METUI['product_list_met_m1156_1_picture']){
					METUI['product_list_met_m1156_1_picture'][i].init();
				}
				METUI['product_list_met_m1156_1'].addClass('active');
			break;
			case 3:
				for(var i in METUI['product_list_met_m1156_1_picture']){
					METUI['product_list_met_m1156_1_picture'][i].destroy(false);
				}
				METUI['product_list_met_m1156_1'].removeClass('active');
			break;
		}
	}
}
var x=new metui(METUI_FUN['product_list_met_m1156_1']);



METUI_FUN['video_list_met_m1156_1']=METUI['video_list_met_m1156_1_x']={
	name: 'video_list_met_m1156_1',
	init: function(){
		if($('.swiper-header').length==0){
			METUI['video_list_met_m1156_1_x'].slide(1);
		}		
	},
	resize: function(res){
		if(METUI['video_list_met_m1156_1'].hasClass('full')) METUI['video_list_met_m1156_1'].height($(window).height());
		if(!res) $(window).resize(function(){ METUI['video_list_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(!METUI['slide']){ 
					METUI['video_list_met_m1156_1']
						.css('background-image','url('+METUI['video_list_met_m1156_1'].attr('data-background')+')')
						.removeAttr('data-background');
				}
				METUI['video_list_met_m1156_1_video']=new Swiper('.video_list_met_m1156_1 .video-list',{
					wrapperClass: 'video-ol',
					slideClass: 'video-li',
					autoplay: 3500,
					observer:true,
					observeParents:true,
					lazyLoading: true,
					lazyLoadingClass: 'video-lazy',
					lazyLoadingOnTransitionStart: true,
					watchSlidesProgress: true,
					watchSlidesVisibility: true,
					simulateTouch: false,
					slidesPerView: 'auto',
					mousewheelControl: true,
					direction: 'vertical',
					onLazyImageReady: function(swiper){
						swiper.update(true);
					}
				});
				METUI['video_list_met_m1156_1'].find('.video-content').click(function(){
					if(METUI['video_list_met_m1156_1'].find('.video-content video').attr('src')){
						if(METUI['video_list_met_m1156_1'].find('.video-content video')[0].paused){
							METUI['video_list_met_m1156_1'].find('.video-content').addClass('play');
							METUI['video_list_met_m1156_1'].find('.video-content video')[0].play();
							if($('.swiper-header #audio').length>0) audio.pause();
						}else{
							METUI['video_list_met_m1156_1'].find('.video-content video')[0].pause();
							if($('.swiper-header #audio').length>0&&status==1) audio.play();
						}
					}
				});
				var autoplay=METUI['video_list_met_m1156_1'].find('.video-list').attr('data-autoplay')==1?true:false;
				if(autoplay&&!$('html').hasClass('isMobile')){
					METUI['video_list_met_m1156_1'].find('.video-content').addClass('play');
					if(METUI['video_list_met_m1156_1'].find('.video-content video').attr('src')){
						METUI['video_list_met_m1156_1'].find('.video-content video')[0].play();
					}
					if($('.swiper-header #audio').length>0) audio.pause();
				}
				METUI['video_list_met_m1156_1'].find('.video-li font').click(function(){
					METUI['video_list_met_m1156_1'].find('.video-left').removeClass('active');
					window.setTimeout(function(){
						METUI['video_list_met_m1156_1'].find('.video-left').addClass('active');
					},1);
					METUI['video_list_met_m1156_1'].find('.video-content').html($(this).attr('data-video')).addClass('play');
					METUI['video_list_met_m1156_1'].find('.video-left h3').text($(this).parent('li').find('a').html());
					METUI['video_list_met_m1156_1'].find('.video-left ul').html($(this).attr('data-para'));
					METUI['video_list_met_m1156_1'].find('.video-left ul font').each(function(index){
						METUI['video_list_met_m1156_1_video_script'+index]=$(this);
						$.get($(this).attr('src'),function(data){
							METUI['video_list_met_m1156_1_video_script'+index].html(data.replace('document.write("','').replace('")',''));
						});
					});
					METUI['video_list_met_m1156_1'].find('.video-left p').text($(this).attr('data-desc'));
					METUI['video_list_met_m1156_1'].find('.video-left a').attr('href',$(this).parent('li').find('a').attr('href'));
					var autoplay=METUI['video_list_met_m1156_1'].find('.video-list').attr('data-autoplay')==1?true:false;
					if(METUI['video_list_met_m1156_1'].find('.video-content video').attr('src')&&autoplay) METUI['video_list_met_m1156_1'].find('.video-content video')[0].play();
					if($(this).attr('data-type')=='') METUI['video_list_met_m1156_1'].find('.video-content').removeClass('video');
					else METUI['video_list_met_m1156_1'].find('.video-content').addClass('video');
					METUI['video_list_met_m1156_1'].find('.video-li').removeClass('active');
					$(this).parent('li').addClass('active');
				});
				METUI['video_list_met_m1156_1'].addClass('active');
			break;
			case 2:
				METUI['video_list_met_m1156_1'].find('.video-content').html(METUI['video_list_met_m1156_1_video_html']);
				METUI['video_list_met_m1156_1_video'].init();
				METUI['video_list_met_m1156_1_video'].enableMousewheelControl();
				var autoplay=METUI['video_list_met_m1156_1'].find('.video-list').attr('data-autoplay')==1?true:false;
				if(METUI['video_list_met_m1156_1'].find('.video-content video').length>0 && autoplay && !$('html').hasClass('isMobile')){
					if(METUI['video_list_met_m1156_1'].find('.video-content video').attr('src')) METUI['video_list_met_m1156_1'].find('.video-content video')[0].play();
					if($('.swiper-header #audio').length>0) audio.pause();
				}
				METUI['video_list_met_m1156_1'].addClass('active');
			break;
			case 3:
				METUI['video_list_met_m1156_1_video'].destroy(false);
				if(METUI['video_list_met_m1156_1'].find('.video-content video').length>0){
					if(METUI['video_list_met_m1156_1'].find('.video-content video').attr('src')) METUI['video_list_met_m1156_1'].find('.video-content video')[0].pause();
					if($('.swiper-header #audio').length>0 && status==1) audio.play();
				}
				METUI['video_list_met_m1156_1_video_html']=METUI['video_list_met_m1156_1'].find('.video-content').html();
				METUI['video_list_met_m1156_1'].find('.video-content').html('');
				METUI['video_list_met_m1156_1'].removeClass('active');
			break;
		}
	}
}
var x=new metui(METUI_FUN['video_list_met_m1156_1']);



METUI_FUN['case_list_met_m1156_1']=METUI['case_list_met_m1156_1_x']={
	name: 'case_list_met_m1156_1',
	IE9: navigator.userAgent.indexOf('MSIE 9.0')>0,
	init: function(){
		if($('.swiper-header').length==0){
			METUI['case_list_met_m1156_1_x'].slide(1);
		}		
	},
	resize: function(res){
		if(METUI['case_list_met_m1156_1'].hasClass('full')) METUI['case_list_met_m1156_1'].height($(window).height());
		if(!res) $(window).resize(function(){ METUI['case_list_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(!METUI['slide']){
					METUI['case_list_met_m1156_1']
						.css('background-image','url('+METUI['case_list_met_m1156_1'].attr('data-background')+')')
						.removeAttr('data-background');
				}
				METUI['case_list_met_m1156_1_case']=new Swiper('.case-list',{
					wrapperClass: 'case-ul',
					slideClass: 'case-li',
					slidesPerView: this.IE9?4:'auto',
					observer: true,
					autoplay: 3500,
					lazyLoading: true,
					lazyLoadingClass: 'case-lazy',
					lazyLoadingOnTransitionStart: true,
					observeParents: true,
					keyboardControl: true,
					watchSlidesProgress : true,
					watchSlidesVisibility : true,
					prevButton: '.case-ctrl .ctrl-left',
					nextButton: '.case-ctrl .ctrl-right'
				});
				METUI['case_list_met_m1156_1'].find('.case-li p').click(function(){
					var imglist = $(this).data("imglist"),
						dyarr = new Array(),
						arlt = imglist.split('|');
					$.each(arlt,function(name,value){
						if(value!=''){
							var st = value.split('*'),
							key = name;
							dyarr[key] = new Array();
							dyarr[key]['src'] = st[1];
							dyarr[key]['thumb'] = st[1];
							dyarr[key]['subHtml'] = st[0];
						}
					});
					$(this).lightGallery({
						autoplayControls:false,
						getCaptionFromTitleOrAlt:false,
						dynamic: true,
						dynamicEl: dyarr,
						thumbWidth:64,
						thumbContHeight:84,
					});
					$(this).on('onSlideClick.lg',function(){
						$('.lg-outer .lg-toolbar').toggleClass('opacity0');
						if($('.lg-outer .lg-toolbar').hasClass('opacity0')){
							$('.lg-outer').removeClass('lg-thumb-open');
						}else{
							$('.lg-outer').addClass('lg-thumb-open');
						}
						if(Breakpoints.is('xs')){
							if($('.lg-outer .lg-toolbar').hasClass('opacity0')){
								$('.lg-outer .lg-actions').addClass('hide');
							}else{
								$('.lg-outer .lg-actions').removeClass('hide');
							}
						}else{
							$('.lg-outer .lg-actions').removeClass('hide');
						}
					});
				});
				METUI['case_list_met_m1156_1'].addClass('active');
			break;
			case 2:
				METUI['case_list_met_m1156_1_case'].init();
				METUI['case_list_met_m1156_1'].addClass('active');
			break;
			case 3:
				METUI['case_list_met_m1156_1_case'].destroy(false);
				METUI['case_list_met_m1156_1'].removeClass('active');
			break;
		}
	}
}
var x=new metui(METUI_FUN['case_list_met_m1156_1']);



METUI_FUN['news_list_met_m1156_1']=METUI['news_list_met_m1156_1_x']={
	name: 'news_list_met_m1156_1',
	init: function(){
		if($('.swiper-header').length==0){
			METUI['news_list_met_m1156_1_x'].slide(1);
		}		
	},
	resize: function(res){
		if(METUI['news_list_met_m1156_1'].hasClass('full')) METUI['news_list_met_m1156_1'].height($(window).height());
		if(!res) $(window).resize(function(){ METUI['news_list_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(!METUI['slide']){
					METUI['news_list_met_m1156_1']
						.css('background-image','url('+METUI['news_list_met_m1156_1'].attr('data-background')+')')
						.removeAttr('data-background')
						.find('img[data-src]').each(function(index, element) {
							$(this).attr('src',$(this).attr('data-src')).removeAttr('data-src');
						});
				}
				if(METUI['news_list_met_m1156_1'].find('.info-list').attr('data-id')!=''){
					METUI['news_list_met_m1156_1_info']=new Swiper('.info-list',{
						wrapperClass: 'info-ul',
						slideClass: 'info-li',
						autoplay: 3500,
						lazyLoading: true,
						lazyLoadingClass: 'info-lazy',
						lazyLoadingInPrevNext: true,
						lazyLoadingOnTransitionStart: true,
						observer:true,
						observeParents:true,
						simulateTouch: false,
						slidesPerView: 'auto',
						mousewheelControl: $(window).width()>992,
						direction: $(window).width()>992?'vertical':'horizontal',
						onLazyImageReady: function(swiper){
							swiper.update(true);
						}
					});
					if(METUI['news_list_met_m1156_1'].find('.info-list').length==1){
						var info=METUI['news_list_met_m1156_1_info'];
						METUI['news_list_met_m1156_1_info'][0]=info;
					}
					for(var i in METUI['news_list_met_m1156_1_info']){
						if(i!=0) METUI['news_list_met_m1156_1_info'][i].stopAutoplay(); 
					}
					$(window).resize(function(){
						if(typeof(info_time)!='undefined') clearTimeout(info_time);
						info_time=window.setTimeout(function(){
							METUI['news_list_met_m1156_1'].find('.info-ul').removeAttr('style');
							for(var i in METUI['news_list_met_m1156_1_info']){
								METUI['news_list_met_m1156_1_info'][i].params.mousewheelControl=$(window).width()>992;
								METUI['news_list_met_m1156_1_info'][i].params.direction=$(window).width()>992?'vertical':'horizontal';
								METUI['news_list_met_m1156_1_info'][i].update();
							}
						},400);
					});
					METUI['news_list_met_m1156_1'].find('.info-nav b').click(function(){
						METUI['news_list_met_m1156_1'].find('.info-nav b').removeClass('active');
						$(this).addClass('active');
						METUI['news_list_met_m1156_1'].find('.info-ease').removeClass('active');
						METUI['news_list_met_m1156_1'].find('.info-ease[data-id='+$(this).attr('data-id')+']').addClass('active');
						for(var i in METUI['news_list_met_m1156_1_info']){
							METUI['news_list_met_m1156_1_info'][i].stopAutoplay(); 
						}
						METUI['news_list_met_m1156_1_info'][$(this).index()].startAutoplay(); 
					});
					METUI['news_list_met_m1156_1'].find('.info-nav b').dblclick(function(){
						window.location.href=$(this).attr('data-href');
					});
				}
				METUI['news_list_met_m1156_1'].addClass('active');
			break;
			case 2:
				for(var i in METUI['news_list_met_m1156_1_info']){
					METUI['news_list_met_m1156_1_info'][i].init();
					METUI['news_list_met_m1156_1_info'][i].enableMousewheelControl();
				}
				METUI['news_list_met_m1156_1'].addClass('active');
			break;
			case 3:
				for(var i in METUI['news_list_met_m1156_1_info']){
					METUI['news_list_met_m1156_1_info'][i].destroy(false);
				}
				METUI['news_list_met_m1156_1'].find('.info-ul').removeAttr('style');
				METUI['news_list_met_m1156_1'].removeClass('active');
			break;
		}
	}
}
var x=new metui(METUI_FUN['news_list_met_m1156_1']);



METUI_FUN['contact_list_met_m1156_1']=METUI['contact_list_met_m1156_1_x']={
	name: 'contact_list_met_m1156_1',
	init: function(){
		if($('.swiper-header').length==0){
			METUI['contact_list_met_m1156_1_x'].slide(1);
		}		
	},
	resize: function(res){
		if(METUI['contact_list_met_m1156_1'].hasClass('full')) METUI['contact_list_met_m1156_1'].height($(window).height());
		if(!res) $(window).resize(function(){ METUI['contact_list_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(!METUI['slide']){
					METUI['contact_list_met_m1156_1']
						.css('background-image','url('+METUI['contact_list_met_m1156_1'].attr('data-background')+')')
						.removeAttr('data-background')
						.find('img[data-src]').each(function(index, element) {
							$(this).attr('src',$(this).attr('data-src')).removeAttr('data-src');
						});
				}
				METUI['contact_list_met_m1156_1_contact']=new Swiper('.contact-right',{
					wrapperClass: 'contact-cut',
					slideClass: 'contact-bin',
					autoplay: 5000,
					observer:true,
					autoHeight: true,
					lazyLoading: true,
					lazyLoadingClass: 'contact-lazy',
					lazyLoadingOnTransitionStart: true,
					keyboardControl: true,
					observeParents: true, 
					simulateTouch: false,
					slidesPerView: 'auto'				
				});
				if(METUI['slide']){
					$('.contact-left').mouseover(function(){
						METUI['slide'].params.onlyExternal=true;
						METUI['slide'].disableMousewheelControl();
					}).mouseout(function(){
						METUI['slide'].params.onlyExternal=false;
						METUI['slide'].enableMousewheelControl();
					});
				}
				METUI['contact_list_met_m1156_1'].addClass('active');
			break;
			case 2:
				METUI['contact_list_met_m1156_1_contact'].init();
				METUI['contact_list_met_m1156_1'].addClass('active');
			break;
			case 3:
				METUI['contact_list_met_m1156_1_contact'].destroy(false);
				METUI['contact_list_met_m1156_1'].removeClass('active');
			break;
		}
	},
	maps: function(){
		if($('script[map=contact_list_met_m1156_1]').length==0){
			$('body').append(
				"<script src=//api.map.baidu.com/api?v=2.0&ak=aL2Gwp389Kxj3bFhSMq7cf9w&callback=METUI['contact_list_met_m1156_1_x'].maps map=contact_list_met_m1156_1></script>");
		}else{
			var icon='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAA'+
					 'Cnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=',
				coordinate=METUI['contact_list_met_m1156_1'].find('.contact-map').attr('coordinate')||'105,25',
				level=METUI['contact_list_met_m1156_1'].find('.contact-map').attr('level')||14,
				dark=METUI['contact_list_met_m1156_1'].find('.contact-map').attr('dark')==1,
				coo=coordinate&&coordinate.split(',');
			var map=new BMap.Map("contact_list_met_m1156_1_map");
			map.centerAndZoom(new BMap.Point(coo[0]*1,coo[1]*1),level);
			map.enableScrollWheelZoom(); 
			if(dark) map.setMapStyle({style:"dark"});
			var Icon = new BMap.Icon(icon+"\" class=\"point-img\"><span></span><br id=\"", new BMap.Size(28,56));
			var marker = new BMap.Marker(new BMap.Point(coo[0]*1,coo[1]*1),{icon:Icon});
			marker.setAnimation(BMAP_ANIMATION_BOUNCE); 
			map.addOverlay(marker);
		}
	}
}
var x=new metui(METUI_FUN['contact_list_met_m1156_1']);
