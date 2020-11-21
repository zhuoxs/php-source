
﻿/**
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

    // 共收录2553条简繁对照
    // 尚未考证是否正确、重复、完整

    /**
     * 简体字
     * @const
     */
    var S = new String('万与丑专业丛东丝丢两严丧个丬丰临为丽举么义乌乐乔习乡书买乱争于亏云亘亚产亩亲亵亸亿仅从仑仓仪们价众优伙会伛伞伟传伤伥伦伧伪伫体余佣佥侠侣侥侦侧侨侩侪侬俣俦俨俩俪俭债倾偬偻偾偿傥傧储傩儿兑兖党兰关兴兹养兽冁内冈册写军农冢冯冲决况冻净凄凉凌减凑凛几凤凫凭凯击凼凿刍划刘则刚创删别刬刭刽刿剀剂剐剑剥剧劝办务劢动励劲劳势勋勐勚匀匦匮区医华协单卖卢卤卧卫却卺厂厅历厉压厌厍厕厢厣厦厨厩厮县参叆叇双发变叙叠叶号叹叽吁后吓吕吗吣吨听启吴呒呓呕呖呗员呙呛呜咏咔咙咛咝咤咴咸哌响哑哒哓哔哕哗哙哜哝哟唛唝唠唡唢唣唤唿啧啬啭啮啰啴啸喷喽喾嗫呵嗳嘘嘤嘱噜噼嚣嚯团园囱围囵国图圆圣圹场坂坏块坚坛坜坝坞坟坠垄垅垆垒垦垧垩垫垭垯垱垲垴埘埙埚埝埯堑堕塆墙壮声壳壶壸处备复够头夸夹夺奁奂奋奖奥妆妇妈妩妪妫姗姜娄娅娆娇娈娱娲娴婳婴婵婶媪嫒嫔嫱嬷孙学孪宁宝实宠审宪宫宽宾寝对寻导寿将尔尘尧尴尸尽层屃屉届属屡屦屿岁岂岖岗岘岙岚岛岭岳岽岿峃峄峡峣峤峥峦崂崃崄崭嵘嵚嵛嵝嵴巅巩巯币帅师帏帐帘帜带帧帮帱帻帼幂幞干并广庄庆庐庑库应庙庞废庼廪开异弃张弥弪弯弹强归当录彟彦彻径徕御忆忏忧忾怀态怂怃怄怅怆怜总怼怿恋恳恶恸恹恺恻恼恽悦悫悬悭悯惊惧惨惩惫惬惭惮惯愍愠愤愦愿慑慭憷懑懒懔戆戋戏戗战戬户扎扑扦执扩扪扫扬扰抚抛抟抠抡抢护报担拟拢拣拥拦拧拨择挂挚挛挜挝挞挟挠挡挢挣挤挥挦捞损捡换捣据捻掳掴掷掸掺掼揸揽揿搀搁搂搅携摄摅摆摇摈摊撄撑撵撷撸撺擞攒敌敛数斋斓斗斩断无旧时旷旸昙昼昽显晋晒晓晔晕晖暂暧札术朴机杀杂权条来杨杩杰极构枞枢枣枥枧枨枪枫枭柜柠柽栀栅标栈栉栊栋栌栎栏树栖样栾桊桠桡桢档桤桥桦桧桨桩梦梼梾检棂椁椟椠椤椭楼榄榇榈榉槚槛槟槠横樯樱橥橱橹橼檐檩欢欤欧歼殁殇残殒殓殚殡殴毁毂毕毙毡毵氇气氢氩氲汇汉污汤汹沓沟没沣沤沥沦沧沨沩沪沵泞泪泶泷泸泺泻泼泽泾洁洒洼浃浅浆浇浈浉浊测浍济浏浐浑浒浓浔浕涂涌涛涝涞涟涠涡涢涣涤润涧涨涩淀渊渌渍渎渐渑渔渖渗温游湾湿溃溅溆溇滗滚滞滟滠满滢滤滥滦滨滩滪漤潆潇潋潍潜潴澜濑濒灏灭灯灵灾灿炀炉炖炜炝点炼炽烁烂烃烛烟烦烧烨烩烫烬热焕焖焘煅煳熘爱爷牍牦牵牺犊犟状犷犸犹狈狍狝狞独狭狮狯狰狱狲猃猎猕猡猪猫猬献獭玑玙玚玛玮环现玱玺珉珏珐珑珰珲琎琏琐琼瑶瑷璇璎瓒瓮瓯电画畅畲畴疖疗疟疠疡疬疮疯疱疴痈痉痒痖痨痪痫痴瘅瘆瘗瘘瘪瘫瘾瘿癞癣癫癯皑皱皲盏盐监盖盗盘眍眦眬着睁睐睑瞒瞩矫矶矾矿砀码砖砗砚砜砺砻砾础硁硅硕硖硗硙硚确硷碍碛碜碱碹磙礼祎祢祯祷祸禀禄禅离秃秆种积称秽秾稆税稣稳穑穷窃窍窑窜窝窥窦窭竖竞笃笋笔笕笺笼笾筑筚筛筜筝筹签简箓箦箧箨箩箪箫篑篓篮篱簖籁籴类籼粜粝粤粪粮糁糇紧絷纟纠纡红纣纤纥约级纨纩纪纫纬纭纮纯纰纱纲纳纴纵纶纷纸纹纺纻纼纽纾线绀绁绂练组绅细织终绉绊绋绌绍绎经绐绑绒结绔绕绖绗绘给绚绛络绝绞统绠绡绢绣绤绥绦继绨绩绪绫绬续绮绯绰绱绲绳维绵绶绷绸绹绺绻综绽绾绿缀缁缂缃缄缅缆缇缈缉缊缋缌缍缎缏缐缑缒缓缔缕编缗缘缙缚缛缜缝缞缟缠缡缢缣缤缥缦缧缨缩缪缫缬缭缮缯缰缱缲缳缴缵罂网罗罚罢罴羁羟羡翘翙翚耢耧耸耻聂聋职聍联聩聪肃肠肤肷肾肿胀胁胆胜胧胨胪胫胶脉脍脏脐脑脓脔脚脱脶脸腊腌腘腭腻腼腽腾膑臜舆舣舰舱舻艰艳艹艺节芈芗芜芦苁苇苈苋苌苍苎苏苘苹茎茏茑茔茕茧荆荐荙荚荛荜荞荟荠荡荣荤荥荦荧荨荩荪荫荬荭荮药莅莜莱莲莳莴莶获莸莹莺莼萚萝萤营萦萧萨葱蒇蒉蒋蒌蓝蓟蓠蓣蓥蓦蔷蔹蔺蔼蕲蕴薮藁藓虏虑虚虫虬虮虽虾虿蚀蚁蚂蚕蚝蚬蛊蛎蛏蛮蛰蛱蛲蛳蛴蜕蜗蜡蝇蝈蝉蝎蝼蝾螀螨蟏衅衔补衬衮袄袅袆袜袭袯装裆裈裢裣裤裥褛褴襁襕见观觃规觅视觇览觉觊觋觌觍觎觏觐觑觞触觯詟誉誊讠计订讣认讥讦讧讨让讪讫训议讯记讱讲讳讴讵讶讷许讹论讻讼讽设访诀证诂诃评诅识诇诈诉诊诋诌词诎诏诐译诒诓诔试诖诗诘诙诚诛诜话诞诟诠诡询诣诤该详诧诨诩诪诫诬语诮误诰诱诲诳说诵诶请诸诹诺读诼诽课诿谀谁谂调谄谅谆谇谈谊谋谌谍谎谏谐谑谒谓谔谕谖谗谘谙谚谛谜谝谞谟谠谡谢谣谤谥谦谧谨谩谪谫谬谭谮谯谰谱谲谳谴谵谶谷豮贝贞负贠贡财责贤败账货质贩贪贫贬购贮贯贰贱贲贳贴贵贶贷贸费贺贻贼贽贾贿赀赁赂赃资赅赆赇赈赉赊赋赌赍赎赏赐赑赒赓赔赕赖赗赘赙赚赛赜赝赞赟赠赡赢赣赪赵赶趋趱趸跃跄跖跞践跶跷跸跹跻踊踌踪踬踯蹑蹒蹰蹿躏躜躯车轧轨轩轪轫转轭轮软轰轱轲轳轴轵轶轷轸轹轺轻轼载轾轿辀辁辂较辄辅辆辇辈辉辊辋辌辍辎辏辐辑辒输辔辕辖辗辘辙辚辞辩辫边辽达迁过迈运还这进远违连迟迩迳迹适选逊递逦逻遗遥邓邝邬邮邹邺邻郁郄郏郐郑郓郦郧郸酝酦酱酽酾酿释里鉅鉴銮錾钆钇针钉钊钋钌钍钎钏钐钑钒钓钔钕钖钗钘钙钚钛钝钞钟钠钡钢钣钤钥钦钧钨钩钪钫钬钭钮钯钰钱钲钳钴钵钶钷钸钹钺钻钼钽钾钿铀铁铂铃铄铅铆铈铉铊铋铍铎铏铐铑铒铕铗铘铙铚铛铜铝铞铟铠铡铢铣铤铥铦铧铨铪铫铬铭铮铯铰铱铲铳铴铵银铷铸铹铺铻铼铽链铿销锁锂锃锄锅锆锇锈锉锊锋锌锍锎锏锐锑锒锓锔锕锖锗错锚锜锞锟锠锡锢锣锤锥锦锨锩锫锬锭键锯锰锱锲锳锴锵锶锷锸锹锺锻锼锽锾锿镀镁镂镃镆镇镈镉镊镌镍镎镏镐镑镒镕镖镗镙镚镛镜镝镞镟镠镡镢镣镤镥镦镧镨镩镪镫镬镭镮镯镰镱镲镳镴镶长门闩闪闫闬闭问闯闰闱闲闳间闵闶闷闸闹闺闻闼闽闾闿阀阁阂阃阄阅阆阇阈阉阊阋阌阍阎阏阐阑阒阓阔阕阖阗阘阙阚阛队阳阴阵阶际陆陇陈陉陕陧陨险随隐隶隽难雏雠雳雾霁霉霭靓静靥鞑鞒鞯鞴韦韧韨韩韪韫韬韵页顶顷顸项顺须顼顽顾顿颀颁颂颃预颅领颇颈颉颊颋颌颍颎颏颐频颒颓颔颕颖颗题颙颚颛颜额颞颟颠颡颢颣颤颥颦颧风飏飐飑飒飓飔飕飖飗飘飙飚飞飨餍饤饥饦饧饨饩饪饫饬饭饮饯饰饱饲饳饴饵饶饷饸饹饺饻饼饽饾饿馀馁馂馃馄馅馆馇馈馉馊馋馌馍馎馏馐馑馒馓馔馕马驭驮驯驰驱驲驳驴驵驶驷驸驹驺驻驼驽驾驿骀骁骂骃骄骅骆骇骈骉骊骋验骍骎骏骐骑骒骓骔骕骖骗骘骙骚骛骜骝骞骟骠骡骢骣骤骥骦骧髅髋髌鬓魇魉鱼鱽鱾鱿鲀鲁鲂鲄鲅鲆鲇鲈鲉鲊鲋鲌鲍鲎鲏鲐鲑鲒鲓鲔鲕鲖鲗鲘鲙鲚鲛鲜鲝鲞鲟鲠鲡鲢鲣鲤鲥鲦鲧鲨鲩鲪鲫鲬鲭鲮鲯鲰鲱鲲鲳鲴鲵鲶鲷鲸鲹鲺鲻鲼鲽鲾鲿鳀鳁鳂鳃鳄鳅鳆鳇鳈鳉鳊鳋鳌鳍鳎鳏鳐鳑鳒鳓鳔鳕鳖鳗鳘鳙鳛鳜鳝鳞鳟鳠鳡鳢鳣鸟鸠鸡鸢鸣鸤鸥鸦鸧鸨鸩鸪鸫鸬鸭鸮鸯鸰鸱鸲鸳鸴鸵鸶鸷鸸鸹鸺鸻鸼鸽鸾鸿鹀鹁鹂鹃鹄鹅鹆鹇鹈鹉鹊鹋鹌鹍鹎鹏鹐鹑鹒鹓鹔鹕鹖鹗鹘鹚鹛鹜鹝鹞鹟鹠鹡鹢鹣鹤鹥鹦鹧鹨鹩鹪鹫鹬鹭鹯鹰鹱鹲鹳鹴鹾麦麸黄黉黡黩黪黾鼋鼌鼍鼗鼹齄齐齑齿龀龁龂龃龄龅龆龇龈龉龊龋龌龙龚龛龟志制咨只里系范松没尝尝闹面准钟别闲干尽脏拼');

    /**
     * 繁体字
     * @const
     */
    var T = new String('萬與醜專業叢東絲丟兩嚴喪個爿豐臨為麗舉麼義烏樂喬習鄉書買亂爭於虧雲亙亞產畝親褻嚲億僅從侖倉儀們價眾優夥會傴傘偉傳傷倀倫傖偽佇體餘傭僉俠侶僥偵側僑儈儕儂俁儔儼倆儷儉債傾傯僂僨償儻儐儲儺兒兌兗黨蘭關興茲養獸囅內岡冊寫軍農塚馮衝決況凍淨淒涼淩減湊凜幾鳳鳧憑凱擊氹鑿芻劃劉則剛創刪別剗剄劊劌剴劑剮劍剝劇勸辦務勱動勵勁勞勢勳猛勩勻匭匱區醫華協單賣盧鹵臥衛卻巹廠廳曆厲壓厭厙廁廂厴廈廚廄廝縣參靉靆雙發變敘疊葉號歎嘰籲後嚇呂嗎唚噸聽啟吳嘸囈嘔嚦唄員咼嗆嗚詠哢嚨嚀噝吒噅鹹呱響啞噠嘵嗶噦嘩噲嚌噥喲嘜嗊嘮啢嗩唕喚呼嘖嗇囀齧囉嘽嘯噴嘍嚳囁嗬噯噓嚶囑嚕劈囂謔團園囪圍圇國圖圓聖壙場阪壞塊堅壇壢壩塢墳墜壟壟壚壘墾坰堊墊埡墶壋塏堖塒塤堝墊垵塹墮壪牆壯聲殼壺壼處備複夠頭誇夾奪奩奐奮獎奧妝婦媽嫵嫗媯姍薑婁婭嬈嬌孌娛媧嫻嫿嬰嬋嬸媼嬡嬪嬙嬤孫學孿寧寶實寵審憲宮寬賓寢對尋導壽將爾塵堯尷屍盡層屭屜屆屬屢屨嶼歲豈嶇崗峴嶴嵐島嶺嶽崠巋嶨嶧峽嶢嶠崢巒嶗崍嶮嶄嶸嶔崳嶁脊巔鞏巰幣帥師幃帳簾幟帶幀幫幬幘幗冪襆幹並廣莊慶廬廡庫應廟龐廢廎廩開異棄張彌弳彎彈強歸當錄彠彥徹徑徠禦憶懺憂愾懷態慫憮慪悵愴憐總懟懌戀懇惡慟懨愷惻惱惲悅愨懸慳憫驚懼慘懲憊愜慚憚慣湣慍憤憒願懾憖怵懣懶懍戇戔戲戧戰戩戶紮撲扡執擴捫掃揚擾撫拋摶摳掄搶護報擔擬攏揀擁攔擰撥擇掛摯攣掗撾撻挾撓擋撟掙擠揮撏撈損撿換搗據撚擄摑擲撣摻摜摣攬撳攙擱摟攪攜攝攄擺搖擯攤攖撐攆擷擼攛擻攢敵斂數齋斕鬥斬斷無舊時曠暘曇晝曨顯晉曬曉曄暈暉暫曖劄術樸機殺雜權條來楊榪傑極構樅樞棗櫪梘棖槍楓梟櫃檸檉梔柵標棧櫛櫳棟櫨櫟欄樹棲樣欒棬椏橈楨檔榿橋樺檜槳樁夢檮棶檢欞槨櫝槧欏橢樓欖櫬櫚櫸檟檻檳櫧橫檣櫻櫫櫥櫓櫞簷檁歡歟歐殲歿殤殘殞殮殫殯毆毀轂畢斃氈毿氌氣氫氬氳彙漢汙湯洶遝溝沒灃漚瀝淪滄渢溈滬濔濘淚澩瀧瀘濼瀉潑澤涇潔灑窪浹淺漿澆湞溮濁測澮濟瀏滻渾滸濃潯濜塗湧濤澇淶漣潿渦溳渙滌潤澗漲澀澱淵淥漬瀆漸澠漁瀋滲溫遊灣濕潰濺漵漊潷滾滯灩灄滿瀅濾濫灤濱灘澦濫瀠瀟瀲濰潛瀦瀾瀨瀕灝滅燈靈災燦煬爐燉煒熗點煉熾爍爛烴燭煙煩燒燁燴燙燼熱煥燜燾煆糊溜愛爺牘犛牽犧犢強狀獷獁猶狽麅獮獰獨狹獅獪猙獄猻獫獵獼玀豬貓蝟獻獺璣璵瑒瑪瑋環現瑲璽瑉玨琺瓏璫琿璡璉瑣瓊瑤璦璿瓔瓚甕甌電畫暢佘疇癤療瘧癘瘍鬁瘡瘋皰屙癰痙癢瘂癆瘓癇癡癉瘮瘞瘺癟癱癮癭癩癬癲臒皚皺皸盞鹽監蓋盜盤瞘眥矓著睜睞瞼瞞矚矯磯礬礦碭碼磚硨硯碸礪礱礫礎硜矽碩硤磽磑礄確鹼礙磧磣堿镟滾禮禕禰禎禱禍稟祿禪離禿稈種積稱穢穠穭稅穌穩穡窮竊竅窯竄窩窺竇窶豎競篤筍筆筧箋籠籩築篳篩簹箏籌簽簡籙簀篋籜籮簞簫簣簍籃籬籪籟糴類秈糶糲粵糞糧糝餱緊縶糸糾紆紅紂纖紇約級紈纊紀紉緯紜紘純紕紗綱納紝縱綸紛紙紋紡紵紖紐紓線紺絏紱練組紳細織終縐絆紼絀紹繹經紿綁絨結絝繞絰絎繪給絢絳絡絕絞統綆綃絹繡綌綏絛繼綈績緒綾緓續綺緋綽緔緄繩維綿綬繃綢綯綹綣綜綻綰綠綴緇緙緗緘緬纜緹緲緝縕繢緦綞緞緶線緱縋緩締縷編緡緣縉縛縟縝縫縗縞纏縭縊縑繽縹縵縲纓縮繆繅纈繚繕繒韁繾繰繯繳纘罌網羅罰罷羆羈羥羨翹翽翬耮耬聳恥聶聾職聹聯聵聰肅腸膚膁腎腫脹脅膽勝朧腖臚脛膠脈膾髒臍腦膿臠腳脫腡臉臘醃膕齶膩靦膃騰臏臢輿艤艦艙艫艱豔艸藝節羋薌蕪蘆蓯葦藶莧萇蒼苧蘇檾蘋莖蘢蔦塋煢繭荊薦薘莢蕘蓽蕎薈薺蕩榮葷滎犖熒蕁藎蓀蔭蕒葒葤藥蒞蓧萊蓮蒔萵薟獲蕕瑩鶯蓴蘀蘿螢營縈蕭薩蔥蕆蕢蔣蔞藍薊蘺蕷鎣驀薔蘞藺藹蘄蘊藪槁蘚虜慮虛蟲虯蟣雖蝦蠆蝕蟻螞蠶蠔蜆蠱蠣蟶蠻蟄蛺蟯螄蠐蛻蝸蠟蠅蟈蟬蠍螻蠑螿蟎蠨釁銜補襯袞襖嫋褘襪襲襏裝襠褌褳襝褲襇褸襤繈襴見觀覎規覓視覘覽覺覬覡覿覥覦覯覲覷觴觸觶讋譽謄訁計訂訃認譏訐訌討讓訕訖訓議訊記訒講諱謳詎訝訥許訛論訩訟諷設訪訣證詁訶評詛識詗詐訴診詆謅詞詘詔詖譯詒誆誄試詿詩詰詼誠誅詵話誕詬詮詭詢詣諍該詳詫諢詡譸誡誣語誚誤誥誘誨誑說誦誒請諸諏諾讀諑誹課諉諛誰諗調諂諒諄誶談誼謀諶諜謊諫諧謔謁謂諤諭諼讒諮諳諺諦謎諞諝謨讜謖謝謠謗諡謙謐謹謾謫譾謬譚譖譙讕譜譎讞譴譫讖穀豶貝貞負貟貢財責賢敗賬貨質販貪貧貶購貯貫貳賤賁貰貼貴貺貸貿費賀貽賊贄賈賄貲賃賂贓資賅贐賕賑賚賒賦賭齎贖賞賜贔賙賡賠賧賴賵贅賻賺賽賾贗讚贇贈贍贏贛赬趙趕趨趲躉躍蹌蹠躒踐躂蹺蹕躚躋踴躊蹤躓躑躡蹣躕躥躪躦軀車軋軌軒軑軔轉軛輪軟轟軲軻轤軸軹軼軤軫轢軺輕軾載輊轎輈輇輅較輒輔輛輦輩輝輥輞輬輟輜輳輻輯轀輸轡轅轄輾轆轍轔辭辯辮邊遼達遷過邁運還這進遠違連遲邇逕跡適選遜遞邐邏遺遙鄧鄺鄔郵鄒鄴鄰鬱郤郟鄶鄭鄆酈鄖鄲醞醱醬釅釃釀釋裏钜鑒鑾鏨釓釔針釘釗釙釕釷釺釧釤鈒釩釣鍆釹鍚釵鈃鈣鈈鈦鈍鈔鍾鈉鋇鋼鈑鈐鑰欽鈞鎢鉤鈧鈁鈥鈄鈕鈀鈺錢鉦鉗鈷缽鈳鉕鈽鈸鉞鑽鉬鉭鉀鈿鈾鐵鉑鈴鑠鉛鉚鈰鉉鉈鉍鈹鐸鉶銬銠鉺銪鋏鋣鐃銍鐺銅鋁銱銦鎧鍘銖銑鋌銩銛鏵銓鉿銚鉻銘錚銫鉸銥鏟銃鐋銨銀銣鑄鐒鋪鋙錸鋱鏈鏗銷鎖鋰鋥鋤鍋鋯鋨鏽銼鋝鋒鋅鋶鐦鐧銳銻鋃鋟鋦錒錆鍺錯錨錡錁錕錩錫錮鑼錘錐錦鍁錈錇錟錠鍵鋸錳錙鍥鍈鍇鏘鍶鍔鍤鍬鍾鍛鎪鍠鍰鎄鍍鎂鏤鎡鏌鎮鎛鎘鑷鐫鎳鎿鎦鎬鎊鎰鎔鏢鏜鏍鏰鏞鏡鏑鏃鏇鏐鐔钁鐐鏷鑥鐓鑭鐠鑹鏹鐙鑊鐳鐶鐲鐮鐿鑔鑣鑞鑲長門閂閃閆閈閉問闖閏闈閑閎間閔閌悶閘鬧閨聞闥閩閭闓閥閣閡閫鬮閱閬闍閾閹閶鬩閿閽閻閼闡闌闃闠闊闋闔闐闒闕闞闤隊陽陰陣階際陸隴陳陘陝隉隕險隨隱隸雋難雛讎靂霧霽黴靄靚靜靨韃鞽韉韝韋韌韍韓韙韞韜韻頁頂頃頇項順須頊頑顧頓頎頒頌頏預顱領頗頸頡頰頲頜潁熲頦頤頻頮頹頷頴穎顆題顒顎顓顏額顳顢顛顙顥纇顫顬顰顴風颺颭颮颯颶颸颼颻飀飄飆飆飛饗饜飣饑飥餳飩餼飪飫飭飯飲餞飾飽飼飿飴餌饒餉餄餎餃餏餅餑餖餓餘餒餕餜餛餡館餷饋餶餿饞饁饃餺餾饈饉饅饊饌饢馬馭馱馴馳驅馹駁驢駔駛駟駙駒騶駐駝駑駕驛駘驍罵駰驕驊駱駭駢驫驪騁驗騂駸駿騏騎騍騅騌驌驂騙騭騤騷騖驁騮騫騸驃騾驄驏驟驥驦驤髏髖髕鬢魘魎魚魛魢魷魨魯魴魺鮁鮃鯰鱸鮋鮓鮒鮊鮑鱟鮍鮐鮭鮚鮳鮪鮞鮦鰂鮜鱠鱭鮫鮮鮺鯗鱘鯁鱺鰱鰹鯉鰣鰷鯀鯊鯇鮶鯽鯒鯖鯪鯕鯫鯡鯤鯧鯝鯢鯰鯛鯨鯵鯴鯔鱝鰈鰏鱨鯷鰮鰃鰓鱷鰍鰒鰉鰁鱂鯿鰠鼇鰭鰨鰥鰩鰟鰜鰳鰾鱈鱉鰻鰵鱅鰼鱖鱔鱗鱒鱯鱤鱧鱣鳥鳩雞鳶鳴鳲鷗鴉鶬鴇鴆鴣鶇鸕鴨鴞鴦鴒鴟鴝鴛鴬鴕鷥鷙鴯鴰鵂鴴鵃鴿鸞鴻鵐鵓鸝鵑鵠鵝鵒鷳鵜鵡鵲鶓鵪鶤鵯鵬鵮鶉鶊鵷鷫鶘鶡鶚鶻鶿鶥鶩鷊鷂鶲鶹鶺鷁鶼鶴鷖鸚鷓鷚鷯鷦鷲鷸鷺鸇鷹鸌鸏鸛鸘鹺麥麩黃黌黶黷黲黽黿鼂鼉鞀鼴齇齊齏齒齔齕齗齟齡齙齠齜齦齬齪齲齷龍龔龕龜誌製谘隻裡係範鬆冇嚐嘗鬨麵準鐘彆閒乾儘臟拚');

    /**
     * 转换文本
     * @param {String} str - 待转换的文本
     * @param {Boolean} toT - 是否转换成繁体
     * @returns {String} - 转换结果
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
            
            // 根据字符的Unicode判断是否为汉字，以提高性能
            // 参考:
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
     * 转换HTML Element属性
     * @param {Element} element - 待转换的HTML Element节点
     * @param {String|Array} attr - 待转换的属性/属性列表
     * @param {Boolean} toT - 是否转换成繁体
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
     * 转换HTML Element节点
     * @param {Element} element - 待转换的HTML Element节点
     * @param {Boolean} toT - 是否转换成繁体
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

            // 若为HTML Element节点
            if (childNode.nodeType === 1) {
                // 对以下标签不做处理
                if ("|BR|HR|TEXTAREA|SCRIPT|OBJECT|EMBED|".indexOf("|" + childNode.tagName + "|") !== -1) {
                    continue;
                }
                
                tranAttr(childNode, ['title', 'data-original-title', 'alt', 'placeholder'], toT);

                // input 标签
                // 对text类型的input输入框不做处理
                if (childNode.tagName === "INPUT"
                    && childNode.value !== ""
                    && childNode.type !== "text"
                    && childNode.type !== "hidden")
                {
                    childNode.value = tranStr(childNode.value, toT);
                }

                // 继续递归调用
                tranElement(childNode, toT);
            } else if (childNode.nodeType === 3) {  // 若为文本节点
                childNode.data = tranStr(childNode.data, toT);
            }
        }
    }

    // 扩展jQuery全局方法
    $.extend({
        /**
         * 文本简转繁
         * @param {String} str - 待转换的文本
         * @returns {String} 转换结果
         */
        s2t: function(str) {
            return tranStr(str, true);
        },

        /**
         * 文本繁转简
         * @param {String} str - 待转换的文本
         * @returns {String} 转换结果
         */
        t2s: function(str) {
            return tranStr(str, false);
        }
    });

    // 扩展jQuery对象方法
    $.fn.extend({
        /**
         * jQuery Objects简转繁
         * @this {jQuery Objects} 待转换的jQuery Objects
         */
        s2t: function() {
            return this.each(function() {
                tranElement(this, true);
            });
        },

        /**
         * jQuery Objects繁转简
         * @this {jQuery Objects} 待转换的jQuery Objects
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
        canvasPosition=function(from_dom,to_dom){ // canvas设置
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
                    // 图片高斯模糊加载小图
                    if(!$self.attr('data-minimg')){
                        // 设置小图路径
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
                            // 高斯模糊小图
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

/*!
 * FormValidation (http://formvalidation.io)
 * The best jQuery plugin to validate form fields. Support Bootstrap, Foundation, Pure, SemanticUI, UIKit and custom frameworks
 *
 * @version     v0.8.1, built on 2016-07-29 1:10:55 AM
 * @author      https://twitter.com/formvalidation
 * @copyright   (c) 2013 - 2016 Nguyen Huu Phuoc
 * @license     http://formvalidation.io/license/
 */
if(window.FormValidation={AddOn:{},Framework:{},I18n:{},Validator:{}},"undefined"==typeof jQuery)throw new Error("FormValidation requires jQuery");!function(t){var e=t.fn.jquery.split(" ")[0].split(".");if(+e[0]<2&&+e[1]<9||1==+e[0]&&9==+e[1]&&+e[2]<1)throw new Error("FormValidation requires jQuery version 1.9.1 or higher")}(jQuery),function(t){FormValidation.Base=function(e,a,i){this.$form=t(e),this.options=t.extend({},t.fn.formValidation.DEFAULT_OPTIONS,a),this._namespace=i||"fv",this.$invalidFields=t([]),this.$submitButton=null,this.$hiddenButton=null,this.STATUS_NOT_VALIDATED="NOT_VALIDATED",this.STATUS_VALIDATING="VALIDATING",this.STATUS_INVALID="INVALID",this.STATUS_VALID="VALID",this.STATUS_IGNORED="IGNORED",this.DEFAULT_MESSAGE=t.fn.formValidation.DEFAULT_MESSAGE,this._ieVersion=function(){for(var t=3,e=document.createElement("div"),a=e.all||[];e.innerHTML="\x3c!--[if gt IE "+ ++t+"]><br><![endif]--\x3e",a[0];);return t>4?t:document.documentMode}();var r=document.createElement("div"),n=this;this._changeEvent=9!==this._ieVersion&&"oninput"in r?"input":"keyup",this._submitIfValid=null,this._cacheFields={},function(){if("undefined"!=typeof M&&M.weburl&&M.plugin_lang&&"cn"!=M.lang&&"undefined"!=typeof validation_locale){var t=M.weburl+"app/system/include/static2/vendor/formvalidation/language/"+validation_locale+".js";$.cachedScript(t).done(function(t,e,a){n._init()})}else n._init()}()},FormValidation.Base.prototype={constructor:FormValidation.Base,_exceedThreshold:function(e){var a=this._namespace,i=e.attr("data-"+a+"-field"),r=this.options.fields[i].threshold||this.options.threshold;return!r||(-1!==t.inArray(e.attr("type"),["button","checkbox","file","hidden","image","radio","reset","submit"])||e.val().length>=r)},_init:function(){var e=this,a=this._namespace,i={addOns:{},autoFocus:this.$form.attr("data-"+a+"-autofocus"),button:{selector:this.$form.attr("data-"+a+"-button-selector")||this.$form.attr("data-"+a+"-submitbuttons"),disabled:this.$form.attr("data-"+a+"-button-disabled")},control:{valid:this.$form.attr("data-"+a+"-control-valid"),invalid:this.$form.attr("data-"+a+"-control-invalid")},err:{clazz:this.$form.attr("data-"+a+"-err-clazz"),container:this.$form.attr("data-"+a+"-err-container")||this.$form.attr("data-"+a+"-container"),parent:this.$form.attr("data-"+a+"-err-parent")},events:{formInit:this.$form.attr("data-"+a+"-events-form-init"),formPreValidate:this.$form.attr("data-"+a+"-events-form-prevalidate"),formError:this.$form.attr("data-"+a+"-events-form-error"),formReset:this.$form.attr("data-"+a+"-events-form-reset"),formSuccess:this.$form.attr("data-"+a+"-events-form-success"),fieldAdded:this.$form.attr("data-"+a+"-events-field-added"),fieldRemoved:this.$form.attr("data-"+a+"-events-field-removed"),fieldInit:this.$form.attr("data-"+a+"-events-field-init"),fieldError:this.$form.attr("data-"+a+"-events-field-error"),fieldReset:this.$form.attr("data-"+a+"-events-field-reset"),fieldSuccess:this.$form.attr("data-"+a+"-events-field-success"),fieldStatus:this.$form.attr("data-"+a+"-events-field-status"),localeChanged:this.$form.attr("data-"+a+"-events-locale-changed"),validatorError:this.$form.attr("data-"+a+"-events-validator-error"),validatorSuccess:this.$form.attr("data-"+a+"-events-validator-success"),validatorIgnored:this.$form.attr("data-"+a+"-events-validator-ignored")},excluded:this.$form.attr("data-"+a+"-excluded"),icon:{valid:this.$form.attr("data-"+a+"-icon-valid")||this.$form.attr("data-"+a+"-feedbackicons-valid"),invalid:this.$form.attr("data-"+a+"-icon-invalid")||this.$form.attr("data-"+a+"-feedbackicons-invalid"),validating:this.$form.attr("data-"+a+"-icon-validating")||this.$form.attr("data-"+a+"-feedbackicons-validating"),feedback:this.$form.attr("data-"+a+"-icon-feedback")},live:this.$form.attr("data-"+a+"-live"),locale:this.$form.attr("data-"+a+"-locale"),message:this.$form.attr("data-"+a+"-message"),onPreValidate:this.$form.attr("data-"+a+"-onprevalidate"),onError:this.$form.attr("data-"+a+"-onerror"),onReset:this.$form.attr("data-"+a+"-onreset"),onSuccess:this.$form.attr("data-"+a+"-onsuccess"),row:{selector:this.$form.attr("data-"+a+"-row-selector")||this.$form.attr("data-"+a+"-group"),valid:this.$form.attr("data-"+a+"-row-valid"),invalid:this.$form.attr("data-"+a+"-row-invalid"),feedback:this.$form.attr("data-"+a+"-row-feedback")},threshold:this.$form.attr("data-"+a+"-threshold"),trigger:this.$form.attr("data-"+a+"-trigger"),verbose:this.$form.attr("data-"+a+"-verbose"),fields:{}};this.$form.attr("novalidate","novalidate").addClass(this.options.elementClass).on("submit."+a,function(t){t.preventDefault(),e.validate()}).on("click."+a,this.options.button.selector,function(){e.$submitButton=t(this),e._submitIfValid=!0}),(!0===this.options.declarative||"true"===this.options.declarative)&&this.$form.find("[name], [data-"+a+"-field]").each(function(){var r=t(this),n=r.attr("name")||r.attr("data-"+a+"-field"),s=e._parseOptions(r);s&&(r.attr("data-"+a+"-field",n),i.fields[n]=t.extend({},s,i.fields[n]))}),this.options=t.extend(!0,this.options,i),"string"==typeof this.options.err.parent&&(this.options.err.parent=new RegExp(this.options.err.parent)),this.options.container&&(this.options.err.container=this.options.container,delete this.options.container),this.options.feedbackIcons&&(this.options.icon=t.extend(!0,this.options.icon,this.options.feedbackIcons),delete this.options.feedbackIcons),this.options.group&&(this.options.row.selector=this.options.group,delete this.options.group),this.options.submitButtons&&(this.options.button.selector=this.options.submitButtons,delete this.options.submitButtons),FormValidation.I18n[this.options.locale]||(this.options.locale=t.fn.formValidation.DEFAULT_OPTIONS.locale),(!0===this.options.declarative||"true"===this.options.declarative)&&(this.options=t.extend(!0,this.options,{addOns:this._parseAddOnOptions()})),this.$hiddenButton=t("<button/>").attr("type","submit").prependTo(this.$form).addClass("fv-hidden-submit").css({display:"none",width:0,height:0}),this.$form.on("click."+this._namespace,'[type="submit"]',function(a){if(!a.isDefaultPrevented()){var i=t(a.target),r=i.is('[type="submit"]')?i.eq(0):i.parent('[type="submit"]').eq(0);if(e.options.button.selector&&!r.is(e.options.button.selector)&&!r.is(e.$hiddenButton))return e.$form.off("submit."+e._namespace).submit(),!1}});for(var r in this.options.fields)this._initField(r);for(var n in this.options.addOns)"function"==typeof FormValidation.AddOn[n].init&&FormValidation.AddOn[n].init(this,this.options.addOns[n]);this.$form.trigger(t.Event(this.options.events.formInit),{bv:this,fv:this,options:this.options}),this.options.onPreValidate&&this.$form.on(this.options.events.formPreValidate,function(t){FormValidation.Helper.call(e.options.onPreValidate,[t])}),this.options.onSuccess&&this.$form.on(this.options.events.formSuccess,function(t){FormValidation.Helper.call(e.options.onSuccess,[t])}),this.options.onError&&this.$form.on(this.options.events.formError,function(t){FormValidation.Helper.call(e.options.onError,[t])}),this.options.onReset&&this.$form.on(this.options.events.formReset,function(t){FormValidation.Helper.call(e.options.onReset,[t])})},_initField:function(e){var a=this._namespace,i=t([]);switch(typeof e){case"object":i=e,e=e.attr("data-"+a+"-field");break;case"string":(i=this.getFieldElements(e)).attr("data-"+a+"-field",e)}if(0!==i.length&&null!==this.options.fields[e]&&null!==this.options.fields[e].validators){var r,n,s=this.options.fields[e].validators;for(r in s)n=s[r].alias||r,FormValidation.Validator[n]||delete this.options.fields[e].validators[r];null===this.options.fields[e].enabled&&(this.options.fields[e].enabled=!0);for(var o=this,l=i.length,d=i.attr("type"),u=1===l||"radio"===d||"checkbox"===d,f=this._getFieldTrigger(i.eq(0)),c=this.options.err.clazz.split(" ").join("."),h=t.map(f,function(t){return t+".update."+a}).join(" "),p=0;l>p;p++){var m=i.eq(p),v=this.options.fields[e].row||this.options.row.selector,g=m.closest(v),A="function"==typeof(this.options.fields[e].container||this.options.fields[e].err||this.options.err.container)?(this.options.fields[e].container||this.options.fields[e].err||this.options.err.container).call(this,m,this):this.options.fields[e].container||this.options.fields[e].err||this.options.err.container,I=A&&"tooltip"!==A&&"popover"!==A?t(A):this._getMessageContainer(m,v);A&&"tooltip"!==A&&"popover"!==A&&I.addClass(this.options.err.clazz),I.find("."+c+"[data-"+a+"-validator][data-"+a+'-for="'+e+'"]').remove(),g.find("i[data-"+a+'-icon-for="'+e+'"]').remove(),m.off(h).on(h,function(){o.updateStatus(t(this),o.STATUS_NOT_VALIDATED)}),m.data(a+".messages",I);for(r in s)m.data(a+".result."+r,this.STATUS_NOT_VALIDATED),u&&p!==l-1||t("<small/>").css("display","none").addClass(this.options.err.clazz).attr("data-"+a+"-validator",r).attr("data-"+a+"-for",e).attr("data-"+a+"-result",this.STATUS_NOT_VALIDATED).html(this._getMessage(e,r)).appendTo(I),n=s[r].alias||r,"function"==typeof FormValidation.Validator[n].init&&FormValidation.Validator[n].init(this,m,this.options.fields[e].validators[r],r);if(!1!==this.options.fields[e].icon&&"false"!==this.options.fields[e].icon&&this.options.icon&&this.options.icon.valid&&this.options.icon.invalid&&this.options.icon.validating&&(!u||p===l-1)){g.addClass(this.options.row.feedback);var b=t("<i/>").css("display","none").addClass(this.options.icon.feedback).attr("data-"+a+"-icon-for",e).insertAfter(m);(u?i:m).data(a+".icon",b),("tooltip"===A||"popover"===A)&&((u?i:m).on(this.options.events.fieldError,function(){g.addClass("fv-has-tooltip")}).on(this.options.events.fieldSuccess,function(){g.removeClass("fv-has-tooltip")}),m.off("focus.container."+a).on("focus.container."+a,function(){o._showTooltip(t(this),A)}).off("blur.container."+a).on("blur.container."+a,function(){o._hideTooltip(t(this),A)})),"string"==typeof this.options.fields[e].icon&&"true"!==this.options.fields[e].icon?b.appendTo(t(this.options.fields[e].icon)):this._fixIcon(m,b)}}var F=[];for(r in s)n=s[r].alias||r,s[r].priority=parseInt(s[r].priority||FormValidation.Validator[n].priority||1,10),F.push({validator:r,priority:s[r].priority});F=F.sort(function(t,e){return t.priority-e.priority}),i.data(a+".validators",F).on(this.options.events.fieldSuccess,function(t,e){var a=o.getOptions(e.field,null,"onSuccess");a&&FormValidation.Helper.call(a,[t,e])}).on(this.options.events.fieldError,function(t,e){var a=o.getOptions(e.field,null,"onError");a&&FormValidation.Helper.call(a,[t,e])}).on(this.options.events.fieldReset,function(t,e){var a=o.getOptions(e.field,null,"onReset");a&&FormValidation.Helper.call(a,[t,e])}).on(this.options.events.fieldStatus,function(t,e){var a=o.getOptions(e.field,null,"onStatus");a&&FormValidation.Helper.call(a,[t,e])}).on(this.options.events.validatorError,function(t,e){var a=o.getOptions(e.field,e.validator,"onError");a&&FormValidation.Helper.call(a,[t,e])}).on(this.options.events.validatorIgnored,function(t,e){var a=o.getOptions(e.field,e.validator,"onIgnored");a&&FormValidation.Helper.call(a,[t,e])}).on(this.options.events.validatorSuccess,function(t,e){var a=o.getOptions(e.field,e.validator,"onSuccess");a&&FormValidation.Helper.call(a,[t,e])}),this.onLiveChange(i,"live",function(){o._exceedThreshold(t(this))&&o.validateField(t(this))}),i.trigger(t.Event(this.options.events.fieldInit),{bv:this,fv:this,field:e,element:i})}},_isExcluded:function(e){var a=this._namespace,i=e.attr("data-"+a+"-excluded"),r=e.attr("data-"+a+"-field")||e.attr("name");switch(!0){case!!r&&this.options.fields&&this.options.fields[r]&&("true"===this.options.fields[r].excluded||!0===this.options.fields[r].excluded):case"true"===i:case""===i:return!0;case!!r&&this.options.fields&&this.options.fields[r]&&("false"===this.options.fields[r].excluded||!1===this.options.fields[r].excluded):case"false"===i:return!1;case!!r&&this.options.fields&&this.options.fields[r]&&"function"==typeof this.options.fields[r].excluded:return this.options.fields[r].excluded.call(this,e,this);case!!r&&this.options.fields&&this.options.fields[r]&&"string"==typeof this.options.fields[r].excluded:case i:return FormValidation.Helper.call(this.options.fields[r].excluded,[e,this]);default:if(this.options.excluded){"string"==typeof this.options.excluded&&(this.options.excluded=t.map(this.options.excluded.split(","),function(e){return t.trim(e)}));for(var n=this.options.excluded.length,s=0;n>s;s++)if("string"==typeof this.options.excluded[s]&&e.is(this.options.excluded[s])||"function"==typeof this.options.excluded[s]&&!0===this.options.excluded[s].call(this,e,this))return!0}return!1}},_getFieldTrigger:function(t){var e=this._namespace,a=t.data(e+".trigger");if(a)return a;var i=t.attr("type"),r=t.attr("data-"+e+"-field"),n="radio"===i||"checkbox"===i||"file"===i||"SELECT"===t.get(0).tagName?"change":this._ieVersion>=10&&t.attr("placeholder")?"keyup":this._changeEvent;return a=((this.options.fields[r]?this.options.fields[r].trigger:null)||this.options.trigger||n).split(" "),t.data(e+".trigger",a),a},_getMessage:function(t,e){if(!this.options.fields[t]||!this.options.fields[t].validators)return"";var a=this.options.fields[t].validators,i=a[e]&&a[e].alias?a[e].alias:e;if(!FormValidation.Validator[i])return"";switch(!0){case!!a[e].message:return a[e].message;case!!this.options.fields[t].message:return this.options.fields[t].message;case!!this.options.message:return this.options.message;case!!FormValidation.I18n[this.options.locale]&&!!FormValidation.I18n[this.options.locale][i]&&!!FormValidation.I18n[this.options.locale][i].default:return FormValidation.I18n[this.options.locale][i].default;default:return this.DEFAULT_MESSAGE}},_getMessageContainer:function(t,e){if(!this.options.err.parent)throw new Error("The err.parent option is not defined");var a=t.parent();if(a.is(e))return a;var i=a.attr("class");return i&&this.options.err.parent.test(i)?a:this._getMessageContainer(a,e)},_parseAddOnOptions:function(){var t=this._namespace,e=this.$form.attr("data-"+t+"-addons"),a=this.options.addOns||{};if(e){e=e.replace(/\s/g,"").split(",");for(var i=0;i<e.length;i++)a[e[i]]||(a[e[i]]={})}var r,n,s,o;for(r in a)if(FormValidation.AddOn[r]){if(n=FormValidation.AddOn[r].html5Attributes)for(s in n)(o=this.$form.attr("data-"+t+"-addons-"+r.toLowerCase()+"-"+s.toLowerCase()))&&(a[r][n[s]]=o)}else delete a[r];return a},_parseOptions:function(e){var a,i,r,n,s,o,l,d,u,f=this._namespace,c=e.attr("name")||e.attr("data-"+f+"-field"),h={},p=new RegExp("^data-"+f+"-([a-z]+)-alias$"),m=t.extend({},FormValidation.Validator);t.each(e.get(0).attributes,function(t,e){e.value&&p.test(e.name)&&(i=e.name.split("-")[2],m[e.value]&&(m[i]=m[e.value],m[i].alias=e.value))});for(i in m)if(a=m[i],r="data-"+f+"-"+i.toLowerCase(),n=e.attr(r)+"",(u="function"==typeof a.enableByHtml5?a.enableByHtml5(e):null)&&"false"!==n||!0!==u&&(""===n||"true"===n||r===n.toLowerCase())){a.html5Attributes=t.extend({},{message:"message",onerror:"onError",onreset:"onReset",onsuccess:"onSuccess",priority:"priority",transformer:"transformer"},a.html5Attributes),h[i]=t.extend({},!0===u?{}:u,h[i]),a.alias&&(h[i].alias=a.alias);for(d in a.html5Attributes)s=a.html5Attributes[d],o="data-"+f+"-"+i.toLowerCase()+"-"+d,(l=e.attr(o))&&("true"===l||o===l.toLowerCase()?l=!0:"false"===l&&(l=!1),h[i][s]=l)}var v={autoFocus:e.attr("data-"+f+"-autofocus"),err:e.attr("data-"+f+"-err-container")||e.attr("data-"+f+"-container"),enabled:e.attr("data-"+f+"-enabled"),excluded:e.attr("data-"+f+"-excluded"),icon:e.attr("data-"+f+"-icon")||e.attr("data-"+f+"-feedbackicons")||(this.options.fields&&this.options.fields[c]?this.options.fields[c].feedbackIcons:null),message:e.attr("data-"+f+"-message"),onError:e.attr("data-"+f+"-onerror"),onReset:e.attr("data-"+f+"-onreset"),onStatus:e.attr("data-"+f+"-onstatus"),onSuccess:e.attr("data-"+f+"-onsuccess"),row:e.attr("data-"+f+"-row")||e.attr("data-"+f+"-group")||(this.options.fields&&this.options.fields[c]?this.options.fields[c].group:null),selector:e.attr("data-"+f+"-selector"),threshold:e.attr("data-"+f+"-threshold"),transformer:e.attr("data-"+f+"-transformer"),trigger:e.attr("data-"+f+"-trigger"),verbose:e.attr("data-"+f+"-verbose"),validators:h},g=t.isEmptyObject(v);return!t.isEmptyObject(h)||!g&&this.options.fields&&this.options.fields[c]?v:null},_submit:function(){var e=this.isValid();if(null!==e){var a=e?this.options.events.formSuccess:this.options.events.formError,i=t.Event(a);this.$form.trigger(i),this.$submitButton&&(e?this._onSuccess(i):this._onError(i))}},_onError:function(e){if(!e.isDefaultPrevented()){if("submitted"===this.options.live){this.options.live="enabled";var a=this;for(var i in this.options.fields)!function(e){var i=a.getFieldElements(e);i.length&&a.onLiveChange(i,"live",function(){a._exceedThreshold(t(this))&&a.validateField(t(this))})}(i)}for(var r=this._namespace,n=0;n<this.$invalidFields.length;n++){var s=this.$invalidFields.eq(n);if(this.isOptionEnabled(s.attr("data-"+r+"-field"),"autoFocus")){s.focus();break}}}},_onFieldValidated:function(e,a){var i=this._namespace,r=e.attr("data-"+i+"-field"),n=this.options.fields[r].validators,s={},o=0,l={bv:this,fv:this,field:r,element:e,validator:a,result:e.data(i+".response."+a)};if(a)switch(e.data(i+".result."+a)){case this.STATUS_INVALID:e.trigger(t.Event(this.options.events.validatorError),l);break;case this.STATUS_VALID:e.trigger(t.Event(this.options.events.validatorSuccess),l);break;case this.STATUS_IGNORED:e.trigger(t.Event(this.options.events.validatorIgnored),l)}s[this.STATUS_NOT_VALIDATED]=0,s[this.STATUS_VALIDATING]=0,s[this.STATUS_INVALID]=0,s[this.STATUS_VALID]=0,s[this.STATUS_IGNORED]=0;for(var d in n)if(!1!==n[d].enabled){o++;var u=e.data(i+".result."+d);u&&s[u]++}s[this.STATUS_VALID]+s[this.STATUS_IGNORED]===o?(this.$invalidFields=this.$invalidFields.not(e),e.trigger(t.Event(this.options.events.fieldSuccess),l)):(0===s[this.STATUS_NOT_VALIDATED]||!this.isOptionEnabled(r,"verbose"))&&0===s[this.STATUS_VALIDATING]&&s[this.STATUS_INVALID]>0&&(this.$invalidFields=this.$invalidFields.add(e),e.trigger(t.Event(this.options.events.fieldError),l))},_onSuccess:function(t){t.isDefaultPrevented()||this.disableSubmitButtons(!0).defaultSubmit()},_fixIcon:function(t,e){},_createTooltip:function(t,e,a){},_destroyTooltip:function(t,e){},_hideTooltip:function(t,e){},_showTooltip:function(t,e){},defaultSubmit:function(){var e=this._namespace;this.$submitButton&&t("<input/>").attr({type:"hidden",name:this.$submitButton.attr("name")}).attr("data-"+e+"-submit-hidden","").val(this.$submitButton.val()).appendTo(this.$form),this.$form.off("submit."+e).submit()},disableSubmitButtons:function(t){return t?"disabled"!==this.options.live&&this.$form.find(this.options.button.selector).attr("disabled","disabled").addClass(this.options.button.disabled):this.$form.find(this.options.button.selector).removeAttr("disabled").removeClass(this.options.button.disabled),this},getFieldElements:function(e){if(!this._cacheFields[e])if(this.options.fields[e]&&this.options.fields[e].selector){var a=this.$form.find(this.options.fields[e].selector);this._cacheFields[e]=a.length?a:t(this.options.fields[e].selector)}else this._cacheFields[e]=this.$form.find('[name="'+e+'"]');return this._cacheFields[e]},getFieldValue:function(t,e){var a,i=this._namespace;if("string"==typeof t){if(0===(a=this.getFieldElements(t)).length)return null}else a=t,t=a.attr("data-"+i+"-field");if(!t||!this.options.fields[t])return a.val();var r=(this.options.fields[t].validators&&this.options.fields[t].validators[e]?this.options.fields[t].validators[e].transformer:null)||this.options.fields[t].transformer;return r?FormValidation.Helper.call(r,[a,e,this]):a.val()},getNamespace:function(){return this._namespace},getOptions:function(t,e,a){var i=this._namespace;if(!t)return a?this.options[a]:this.options;if("object"==typeof t&&(t=t.attr("data-"+i+"-field")),!this.options.fields[t])return null;var r=this.options.fields[t];return e?r.validators&&r.validators[e]?a?r.validators[e][a]:r.validators[e]:null:a?r[a]:r},getStatus:function(t,e){var a=this._namespace;switch(typeof t){case"object":return t.data(a+".result."+e);case"string":default:return this.getFieldElements(t).eq(0).data(a+".result."+e)}},isOptionEnabled:function(t,e){return!(!this.options.fields[t]||"true"!==this.options.fields[t][e]&&!0!==this.options.fields[t][e])||(!this.options.fields[t]||"false"!==this.options.fields[t][e]&&!1!==this.options.fields[t][e])&&("true"===this.options[e]||!0===this.options[e])},isValid:function(){for(var t in this.options.fields){var e=this.isValidField(t);if(null===e)return null;if(!1===e)return!1}return!0},isValidContainer:function(e){var a=this,i=this._namespace,r=[],n="string"==typeof e?t(e):e;if(0===n.length)return!0;n.find("[data-"+i+"-field]").each(function(){var e=t(this);a._isExcluded(e)||r.push(e)});for(var s=r.length,o=this.options.err.clazz.split(" ").join("."),l=0;s>l;l++){var d=r[l],u=d.attr("data-"+i+"-field"),f=d.data(i+".messages").find("."+o+"[data-"+i+"-validator][data-"+i+'-for="'+u+'"]');if(!this.options.fields||!this.options.fields[u]||"false"!==this.options.fields[u].enabled&&!1!==this.options.fields[u].enabled){if(f.filter("[data-"+i+'-result="'+this.STATUS_INVALID+'"]').length>0)return!1;if(f.filter("[data-"+i+'-result="'+this.STATUS_NOT_VALIDATED+'"]').length>0||f.filter("[data-"+i+'-result="'+this.STATUS_VALIDATING+'"]').length>0)return null}}return!0},isValidField:function(e){var a=this._namespace,i=t([]);switch(typeof e){case"object":i=e,e=e.attr("data-"+a+"-field");break;case"string":i=this.getFieldElements(e)}if(0===i.length||!this.options.fields[e]||"false"===this.options.fields[e].enabled||!1===this.options.fields[e].enabled)return!0;for(var r,n,s,o=i.attr("type"),l="radio"===o||"checkbox"===o?1:i.length,d=0;l>d;d++)if(r=i.eq(d),!this._isExcluded(r))for(n in this.options.fields[e].validators)if(!1!==this.options.fields[e].validators[n].enabled){if((s=r.data(a+".result."+n))===this.STATUS_VALIDATING||s===this.STATUS_NOT_VALIDATED)return null;if(s===this.STATUS_INVALID)return!1}return!0},offLiveChange:function(e,a){if(null===e||0===e.length)return this;var i=this._namespace,r=this._getFieldTrigger(e.eq(0)),n=t.map(r,function(t){return t+"."+a+"."+i}).join(" ");return e.off(n),this},onLiveChange:function(e,a,i){if(null===e||0===e.length)return this;var r=this._namespace,n=this._getFieldTrigger(e.eq(0)),s=t.map(n,function(t){return t+"."+a+"."+r}).join(" ");switch(this.options.live){case"submitted":break;case"disabled":e.off(s);break;case"enabled":default:e.off(s).on(s,function(t){i.apply(this,arguments)})}return this},updateMessage:function(e,a,i){var r=this._namespace,n=t([]);switch(typeof e){case"object":n=e,e=e.attr("data-"+r+"-field");break;case"string":n=this.getFieldElements(e)}var s=this.options.err.clazz.split(" ").join(".");return n.each(function(){t(this).data(r+".messages").find("."+s+"[data-"+r+'-validator="'+a+'"][data-'+r+'-for="'+e+'"]').html(i)}),this},updateStatus:function(e,a,i){var r=this._namespace,n=t([]);switch(typeof e){case"object":n=e,e=e.attr("data-"+r+"-field");break;case"string":n=this.getFieldElements(e)}if(!e||!this.options.fields[e])return this;a===this.STATUS_NOT_VALIDATED&&(this._submitIfValid=!1);for(var s=this,o=n.attr("type"),l=this.options.fields[e].row||this.options.row.selector,d="radio"===o||"checkbox"===o?1:n.length,u=this.options.err.clazz.split(" ").join("."),f=0;d>f;f++){var c=n.eq(f);if(!this._isExcluded(c)){var h,p,m=c.closest(l),v=c.data(r+".messages").find("."+u+"[data-"+r+"-validator][data-"+r+'-for="'+e+'"]'),g=i?v.filter("[data-"+r+'-validator="'+i+'"]'):v,A=c.data(r+".icon"),I="function"==typeof(this.options.fields[e].container||this.options.fields[e].err||this.options.err.container)?(this.options.fields[e].container||this.options.fields[e].err||this.options.err.container).call(this,c,this):this.options.fields[e].container||this.options.fields[e].err||this.options.err.container,b=null;if(i)c.data(r+".result."+i,a);else for(var F in this.options.fields[e].validators)c.data(r+".result."+F,a);switch(g.attr("data-"+r+"-result",a),a){case this.STATUS_VALIDATING:b=null,this.disableSubmitButtons(!0),c.removeClass(this.options.control.valid).removeClass(this.options.control.invalid),m.removeClass(this.options.row.valid).removeClass(this.options.row.invalid),A&&A.removeClass(this.options.icon.valid).removeClass(this.options.icon.invalid).addClass(this.options.icon.validating).show();break;case this.STATUS_INVALID:b=!1,this.disableSubmitButtons(!0),c.removeClass(this.options.control.valid).addClass(this.options.control.invalid),m.removeClass(this.options.row.valid).addClass(this.options.row.invalid),A&&A.removeClass(this.options.icon.valid).removeClass(this.options.icon.validating).addClass(this.options.icon.invalid).show();break;case this.STATUS_IGNORED:case this.STATUS_VALID:h=v.filter("[data-"+r+'-result="'+this.STATUS_VALIDATING+'"]').length>0,p=v.filter("[data-"+r+'-result="'+this.STATUS_NOT_VALIDATED+'"]').length>0;var V=v.filter("[data-"+r+'-result="'+this.STATUS_IGNORED+'"]').length;b=h||p?null:v.filter("[data-"+r+'-result="'+this.STATUS_VALID+'"]').length+V===v.length,c.removeClass(this.options.control.valid).removeClass(this.options.control.invalid),!0===b?(this.disableSubmitButtons(!1===this.isValid()),a===this.STATUS_VALID&&c.addClass(this.options.control.valid)):!1===b&&(this.disableSubmitButtons(!0),a===this.STATUS_VALID&&c.addClass(this.options.control.invalid)),A&&(A.removeClass(this.options.icon.invalid).removeClass(this.options.icon.validating).removeClass(this.options.icon.valid),(a===this.STATUS_VALID||V!==v.length)&&A.addClass(h?this.options.icon.validating:null===b?"":b?this.options.icon.valid:this.options.icon.invalid).show());var S=this.isValidContainer(m);null!==S&&(m.removeClass(this.options.row.valid).removeClass(this.options.row.invalid),(a===this.STATUS_VALID||V!==v.length)&&m.addClass(S?this.options.row.valid:this.options.row.invalid));break;case this.STATUS_NOT_VALIDATED:default:b=null,this.disableSubmitButtons(!1),c.removeClass(this.options.control.valid).removeClass(this.options.control.invalid),m.removeClass(this.options.row.valid).removeClass(this.options.row.invalid),A&&A.removeClass(this.options.icon.valid).removeClass(this.options.icon.invalid).removeClass(this.options.icon.validating).hide()}!A||"tooltip"!==I&&"popover"!==I?a===this.STATUS_INVALID?g.show():g.hide():!1===b?this._createTooltip(c,v.filter("[data-"+r+'-result="'+s.STATUS_INVALID+'"]').eq(0).html(),I):this._destroyTooltip(c,I),c.trigger(t.Event(this.options.events.fieldStatus),{bv:this,fv:this,field:e,element:c,status:a,validator:i}),this._onFieldValidated(c,i)}}return this},validate:function(){if(t.isEmptyObject(this.options.fields))return this._submit(),this;this.$form.trigger(t.Event(this.options.events.formPreValidate)),this.disableSubmitButtons(!0),this._submitIfValid=!1;for(var e in this.options.fields)this.validateField(e);return this._submit(),this._submitIfValid=!0,this},validateField:function(e){var a=this._namespace,i=t([]);switch(typeof e){case"object":i=e,e=e.attr("data-"+a+"-field");break;case"string":i=this.getFieldElements(e)}if(0===i.length||!this.options.fields[e]||"false"===this.options.fields[e].enabled||!1===this.options.fields[e].enabled)return this;for(var r,n,s,o=this,l=i.attr("type"),d="radio"!==l&&"checkbox"!==l||"disabled"===this.options.live?i.length:1,u="radio"===l||"checkbox"===l,f=this.options.fields[e].validators,c=this.isOptionEnabled(e,"verbose"),h=0;d>h;h++){var p=i.eq(h);if(!this._isExcluded(p))for(var m=!1,v=p.data(a+".validators"),g=v.length,A=0;g>A&&(r=v[A].validator,p.data(a+".dfs."+r)&&p.data(a+".dfs."+r).reject(),!m);A++){var I=p.data(a+".result."+r);if(I!==this.STATUS_VALID&&I!==this.STATUS_INVALID)if(!1!==f[r].enabled)if(p.data(a+".result."+r,this.STATUS_VALIDATING),n=f[r].alias||r,"object"==typeof(s=FormValidation.Validator[n].validate(this,p,f[r],r))&&s.resolve)this.updateStatus(u?e:p,this.STATUS_VALIDATING,r),p.data(a+".dfs."+r,s),s.done(function(t,e,i){t.removeData(a+".dfs."+e).data(a+".response."+e,i),i.message&&o.updateMessage(t,e,i.message),o.updateStatus(u?t.attr("data-"+a+"-field"):t,!0===i.valid?o.STATUS_VALID:!1===i.valid?o.STATUS_INVALID:o.STATUS_IGNORED,e),i.valid&&!0===o._submitIfValid?o._submit():!1!==i.valid||c||(m=!0)});else if("object"==typeof s&&void 0!==s.valid){if(p.data(a+".response."+r,s),s.message&&this.updateMessage(u?e:p,r,s.message),this.updateStatus(u?e:p,!0===s.valid?this.STATUS_VALID:!1===s.valid?this.STATUS_INVALID:this.STATUS_IGNORED,r),!1===s.valid&&!c)break}else if("boolean"==typeof s){if(p.data(a+".response."+r,s),this.updateStatus(u?e:p,s?this.STATUS_VALID:this.STATUS_INVALID,r),!s&&!c)break}else null===s&&(p.data(a+".response."+r,s),this.updateStatus(u?e:p,this.STATUS_IGNORED,r));else this.updateStatus(u?e:p,this.STATUS_IGNORED,r);else this._onFieldValidated(p,r)}}return this},addField:function(e,a){var i=this._namespace,r=t([]);switch(typeof e){case"object":r=e,e=e.attr("data-"+i+"-field")||e.attr("name");break;case"string":delete this._cacheFields[e],r=this.getFieldElements(e)}r.attr("data-"+i+"-field",e);for(var n=r.attr("type"),s="radio"===n||"checkbox"===n?1:r.length,o=0;s>o;o++){var l=r.eq(o),d=this._parseOptions(l);d=null===d?a:t.extend(!0,d,a),this.options.fields[e]=t.extend(!0,this.options.fields[e],d),this._cacheFields[e]=this._cacheFields[e]?this._cacheFields[e].add(l):l,this._initField("checkbox"===n||"radio"===n?e:l)}return this.disableSubmitButtons(!1),this.$form.trigger(t.Event(this.options.events.fieldAdded),{field:e,element:r,options:this.options.fields[e]}),this},destroy:function(){var t,e,a,i,r,n,s,o,l=this._namespace;for(e in this.options.fields)for(a=this.getFieldElements(e),t=0;t<a.length;t++){i=a.eq(t);for(r in this.options.fields[e].validators)i.data(l+".dfs."+r)&&i.data(l+".dfs."+r).reject(),i.removeData(l+".result."+r).removeData(l+".response."+r).removeData(l+".dfs."+r),o=this.options.fields[e].validators[r].alias||r,"function"==typeof FormValidation.Validator[o].destroy&&FormValidation.Validator[o].destroy(this,i,this.options.fields[e].validators[r],r)}var d=this.options.err.clazz.split(" ").join(".");for(e in this.options.fields)for(a=this.getFieldElements(e),s=this.options.fields[e].row||this.options.row.selector,t=0;t<a.length;t++){var u=(i=a.eq(t)).data(l+".messages");u&&u.find("."+d+"[data-"+l+"-validator][data-"+l+'-for="'+e+'"]').remove(),i.removeData(l+".messages").removeData(l+".validators").closest(s).removeClass(this.options.row.valid).removeClass(this.options.row.invalid).removeClass(this.options.row.feedback).end().off("."+l).removeAttr("data-"+l+"-field");var f="function"==typeof(this.options.fields[e].container||this.options.fields[e].err||this.options.err.container)?(this.options.fields[e].container||this.options.fields[e].err||this.options.err.container).call(this,i,this):this.options.fields[e].container||this.options.fields[e].err||this.options.err.container;("tooltip"===f||"popover"===f)&&this._destroyTooltip(i,f),(n=i.data(l+".icon"))&&n.remove(),i.removeData(l+".icon").removeData(l+".trigger")}for(var c in this.options.addOns)"function"==typeof FormValidation.AddOn[c].destroy&&FormValidation.AddOn[c].destroy(this,this.options.addOns[c]);this.disableSubmitButtons(!1),this.$hiddenButton.remove(),this.$form.removeClass(this.options.elementClass).off("."+l).removeData("bootstrapValidator").removeData("formValidation").find("[data-"+l+"-submit-hidden]").remove().end().find('[type="submit"]').off("click."+l)},enableFieldValidators:function(t,e,a){var i=this.options.fields[t].validators;if(a&&i&&i[a]&&i[a].enabled!==e)this.options.fields[t].validators[a].enabled=e,this.updateStatus(t,this.STATUS_NOT_VALIDATED,a);else if(!a&&this.options.fields[t].enabled!==e){this.options.fields[t].enabled=e;for(var r in i)this.enableFieldValidators(t,e,r)}return this},getDynamicOption:function(t,e){var a="string"==typeof t?this.getFieldElements(t):t,i=a.val();if("function"==typeof e)return FormValidation.Helper.call(e,[i,this,a]);if("string"==typeof e){var r=this.getFieldElements(e);return r.length?r.val():FormValidation.Helper.call(e,[i,this,a])||e}return null},getForm:function(){return this.$form},getInvalidFields:function(){return this.$invalidFields},getLocale:function(){return this.options.locale},getMessages:function(e,a){var i=this,r=this._namespace,n=[],s=t([]);switch(!0){case e&&"object"==typeof e:s=e;break;case e&&"string"==typeof e:var o=this.getFieldElements(e);if(o.length>0){var l=o.attr("type");s="radio"===l||"checkbox"===l?o.eq(0):o}break;default:s=this.$invalidFields}var d=a?"[data-"+r+'-validator="'+a+'"]':"",u=this.options.err.clazz.split(" ").join(".");return s.each(function(){n=n.concat(t(this).data(r+".messages").find("."+u+"[data-"+r+'-for="'+t(this).attr("data-"+r+"-field")+'"][data-'+r+'-result="'+i.STATUS_INVALID+'"]'+d).map(function(){var e=t(this).attr("data-"+r+"-validator"),a=t(this).attr("data-"+r+"-for");return!1===i.options.fields[a].validators[e].enabled?"":t(this).html()}).get())}),n},getSubmitButton:function(){return this.$submitButton},removeField:function(e){var a=this._namespace,i=t([]);switch(typeof e){case"object":i=e,e=e.attr("data-"+a+"-field")||e.attr("name"),i.attr("data-"+a+"-field",e);break;case"string":i=this.getFieldElements(e)}if(0===i.length)return this;for(var r=i.attr("type"),n="radio"===r||"checkbox"===r?1:i.length,s=0;n>s;s++){var o=i.eq(s);this.$invalidFields=this.$invalidFields.not(o),this._cacheFields[e]=this._cacheFields[e].not(o)}return this._cacheFields[e]&&0!==this._cacheFields[e].length||delete this.options.fields[e],("checkbox"===r||"radio"===r)&&this._initField(e),this.disableSubmitButtons(!1),this.$form.trigger(t.Event(this.options.events.fieldRemoved),{field:e,element:i}),this},resetField:function(e,a){var i=this._namespace,r=t([]);switch(typeof e){case"object":r=e,e=e.attr("data-"+i+"-field");break;case"string":r=this.getFieldElements(e)}var n=0,s=r.length;if(this.options.fields[e])for(n=0;s>n;n++)for(var o in this.options.fields[e].validators)r.eq(n).removeData(i+".dfs."+o);if(a){var l=r.attr("type");"radio"===l||"checkbox"===l?r.prop("checked",!1).removeAttr("selected"):r.val("")}for(this.updateStatus(e,this.STATUS_NOT_VALIDATED),n=0;s>n;n++)r.eq(n).trigger(t.Event(this.options.events.fieldReset),{fv:this,field:e,element:r.eq(n),resetValue:a});return this},resetForm:function(e){for(var a in this.options.fields)this.resetField(a,e);return this.$invalidFields=t([]),this.$submitButton=null,this.disableSubmitButtons(!1),this.$form.trigger(t.Event(this.options.events.formReset),{fv:this,resetValue:e}),this},revalidateField:function(t){return this.updateStatus(t,this.STATUS_NOT_VALIDATED).validateField(t),this},setLocale:function(e){return this.options.locale=e,this.$form.trigger(t.Event(this.options.events.localeChanged),{locale:e,bv:this,fv:this}),this},updateOption:function(t,e,a,i){var r=this._namespace;return"object"==typeof t&&(t=t.attr("data-"+r+"-field")),this.options.fields[t]&&this.options.fields[t].validators[e]&&(this.options.fields[t].validators[e][a]=i,this.updateStatus(t,this.STATUS_NOT_VALIDATED,e)),this},validateContainer:function(e){var a=this,i=this._namespace,r=[],n="string"==typeof e?t(e):e;if(0===n.length)return this;n.find("[data-"+i+"-field]").each(function(){var e=t(this);a._isExcluded(e)||r.push(e)});for(var s=r.length,o=0;s>o;o++)this.validateField(r[o]);return this}},t.fn.formValidation=function(e){var a=arguments;return this.each(function(){var i=t(this),r=i.data("formValidation"),n="object"==typeof e&&e;if(!r){var s=(n.framework||i.attr("data-fv-framework")||"bootstrap").toLowerCase(),o=s.substr(0,1).toUpperCase()+s.substr(1);if(void 0===FormValidation.Framework[o])throw new Error("The class FormValidation.Framework."+o+" is not implemented");r=new FormValidation.Framework[o](this,n),i.addClass("fv-form-"+s).data("formValidation",r)}"string"==typeof e&&r[e].apply(r,Array.prototype.slice.call(a,1))})},t.fn.formValidation.Constructor=FormValidation.Base,t.fn.formValidation.DEFAULT_MESSAGE="This value is not valid",t.fn.formValidation.DEFAULT_OPTIONS={autoFocus:!0,declarative:!0,elementClass:"fv-form",events:{formInit:"init.form.fv",formPreValidate:"prevalidate.form.fv",formError:"err.form.fv",formReset:"rst.form.fv",formSuccess:"success.form.fv",fieldAdded:"added.field.fv",fieldRemoved:"removed.field.fv",fieldInit:"init.field.fv",fieldError:"err.field.fv",fieldReset:"rst.field.fv",fieldSuccess:"success.field.fv",fieldStatus:"status.field.fv",localeChanged:"changed.locale.fv",validatorError:"err.validator.fv",validatorSuccess:"success.validator.fv",validatorIgnored:"ignored.validator.fv"},excluded:[":disabled",":hidden",":not(:visible)"],fields:null,live:"enabled",locale:"en_US",message:null,threshold:null,verbose:!0,button:{selector:'[type="submit"]:not([formnovalidate])',disabled:""},control:{valid:"",invalid:""},err:{clazz:"",container:null,parent:null},icon:{valid:null,invalid:null,validating:null,feedback:""},row:{selector:null,valid:"",invalid:"",feedback:""}}}(jQuery),function(t){FormValidation.Helper={call:function(t,e){if("function"==typeof t)return t.apply(this,e);if("string"==typeof t){"()"===t.substring(t.length-2)&&(t=t.substring(0,t.length-2));for(var a=t.split("."),i=a.pop(),r=window,n=0;n<a.length;n++)r=r[a[n]];return void 0===r[i]?null:r[i].apply(this,e)}},date:function(t,e,a,i){if(isNaN(t)||isNaN(e)||isNaN(a))return!1;if(a.length>2||e.length>2||t.length>4)return!1;if(a=parseInt(a,10),e=parseInt(e,10),1e3>(t=parseInt(t,10))||t>9999||0>=e||e>12)return!1;var r=[31,28,31,30,31,30,31,31,30,31,30,31];if((t%400==0||t%100!=0&&t%4==0)&&(r[1]=29),0>=a||a>r[e-1])return!1;if(!0===i){var n=new Date,s=n.getFullYear(),o=n.getMonth(),l=n.getDate();return s>t||t===s&&o>e-1||t===s&&e-1===o&&l>a}return!0},format:function(e,a){t.isArray(a)||(a=[a]);for(var i in a)e=e.replace("%s",a[i]);return e},luhn:function(t){for(var e=t.length,a=0,i=[[0,1,2,3,4,5,6,7,8,9],[0,2,4,6,8,1,3,5,7,9]],r=0;e--;)r+=i[a][parseInt(t.charAt(e),10)],a^=1;return r%10==0&&r>0},mod11And10:function(t){for(var e=5,a=t.length,i=0;a>i;i++)e=(2*(e||10)%11+parseInt(t.charAt(i),10))%10;return 1===e},mod37And36:function(t,e){for(var a=(e=e||"0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ").length,i=t.length,r=Math.floor(a/2),n=0;i>n;n++)r=(2*(r||a)%(a+1)+e.indexOf(t.charAt(n)))%a;return 1===r}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{base64:{default:"Please enter a valid base 64 encoded"}}}),FormValidation.Validator.base64={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);return""===r||/^(?:[A-Za-z0-9+\/]{4})*(?:[A-Za-z0-9+\/]{2}==|[A-Za-z0-9+\/]{3}=|[A-Za-z0-9+\/]{4})$/.test(r)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{between:{default:"Please enter a value between %s and %s",notInclusive:"Please enter a value between %s and %s strictly"}}}),FormValidation.Validator.between={html5Attributes:{message:"message",min:"min",max:"max",inclusive:"inclusive"},enableByHtml5:function(t){return"range"===t.attr("type")&&{min:t.attr("min"),max:t.attr("max")}},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;n=this._format(n);var s=e.getLocale(),o=t.isNumeric(i.min)?i.min:e.getDynamicOption(a,i.min),l=t.isNumeric(i.max)?i.max:e.getDynamicOption(a,i.max),d=this._format(o),u=this._format(l);return!0===i.inclusive||void 0===i.inclusive?{valid:t.isNumeric(n)&&parseFloat(n)>=d&&parseFloat(n)<=u,message:FormValidation.Helper.format(i.message||FormValidation.I18n[s].between.default,[o,l])}:{valid:t.isNumeric(n)&&parseFloat(n)>d&&parseFloat(n)<u,message:FormValidation.Helper.format(i.message||FormValidation.I18n[s].between.notInclusive,[o,l])}},_format:function(t){return(t+"").replace(",",".")}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{bic:{default:"Please enter a valid BIC number"}}}),FormValidation.Validator.bic={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);return""===r||/^[a-zA-Z]{6}[a-zA-Z0-9]{2}([a-zA-Z0-9]{3})?$/.test(r)}}}(jQuery),function(t){FormValidation.Validator.blank={validate:function(t,e,a,i){return!0}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{callback:{default:"Please enter a valid value"}}}),FormValidation.Validator.callback={priority:999,html5Attributes:{message:"message",callback:"callback"},validate:function(e,a,i,r){var n=e.getFieldValue(a,r),s=new t.Deferred,o={valid:!0};if(i.callback){var l=FormValidation.Helper.call(i.callback,[n,e,a]);o="boolean"==typeof l||null===l?{valid:l}:l}return s.resolve(a,r,o),s}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{choice:{default:"Please enter a valid value",less:"Please choose %s options at minimum",more:"Please choose %s options at maximum",between:"Please choose %s - %s options"}}}),FormValidation.Validator.choice={html5Attributes:{message:"message",min:"min",max:"max"},validate:function(e,a,i,r){var n=e.getLocale(),s=e.getNamespace(),o=a.is("select")?e.getFieldElements(a.attr("data-"+s+"-field")).find("option").filter(":selected").length:e.getFieldElements(a.attr("data-"+s+"-field")).filter(":checked").length,l=i.min?t.isNumeric(i.min)?i.min:e.getDynamicOption(a,i.min):null,d=i.max?t.isNumeric(i.max)?i.max:e.getDynamicOption(a,i.max):null,u=!0,f=i.message||FormValidation.I18n[n].choice.default;switch((l&&o<parseInt(l,10)||d&&o>parseInt(d,10))&&(u=!1),!0){case!!l&&!!d:f=FormValidation.Helper.format(i.message||FormValidation.I18n[n].choice.between,[parseInt(l,10),parseInt(d,10)]);break;case!!l:f=FormValidation.Helper.format(i.message||FormValidation.I18n[n].choice.less,parseInt(l,10));break;case!!d:f=FormValidation.Helper.format(i.message||FormValidation.I18n[n].choice.more,parseInt(d,10))}return{valid:u,message:f}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{color:{default:"Please enter a valid color"}}}),FormValidation.Validator.color={html5Attributes:{message:"message",type:"type"},enableByHtml5:function(t){return"color"===t.attr("type")},SUPPORTED_TYPES:["hex","rgb","rgba","hsl","hsla","keyword"],KEYWORD_COLORS:["aliceblue","antiquewhite","aqua","aquamarine","azure","beige","bisque","black","blanchedalmond","blue","blueviolet","brown","burlywood","cadetblue","chartreuse","chocolate","coral","cornflowerblue","cornsilk","crimson","cyan","darkblue","darkcyan","darkgoldenrod","darkgray","darkgreen","darkgrey","darkkhaki","darkmagenta","darkolivegreen","darkorange","darkorchid","darkred","darksalmon","darkseagreen","darkslateblue","darkslategray","darkslategrey","darkturquoise","darkviolet","deeppink","deepskyblue","dimgray","dimgrey","dodgerblue","firebrick","floralwhite","forestgreen","fuchsia","gainsboro","ghostwhite","gold","goldenrod","gray","green","greenyellow","grey","honeydew","hotpink","indianred","indigo","ivory","khaki","lavender","lavenderblush","lawngreen","lemonchiffon","lightblue","lightcoral","lightcyan","lightgoldenrodyellow","lightgray","lightgreen","lightgrey","lightpink","lightsalmon","lightseagreen","lightskyblue","lightslategray","lightslategrey","lightsteelblue","lightyellow","lime","limegreen","linen","magenta","maroon","mediumaquamarine","mediumblue","mediumorchid","mediumpurple","mediumseagreen","mediumslateblue","mediumspringgreen","mediumturquoise","mediumvioletred","midnightblue","mintcream","mistyrose","moccasin","navajowhite","navy","oldlace","olive","olivedrab","orange","orangered","orchid","palegoldenrod","palegreen","paleturquoise","palevioletred","papayawhip","peachpuff","peru","pink","plum","powderblue","purple","red","rosybrown","royalblue","saddlebrown","salmon","sandybrown","seagreen","seashell","sienna","silver","skyblue","slateblue","slategray","slategrey","snow","springgreen","steelblue","tan","teal","thistle","tomato","transparent","turquoise","violet","wheat","white","whitesmoke","yellow","yellowgreen"],validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;if(this.enableByHtml5(a))return/^#[0-9A-F]{6}$/i.test(n);var s=i.type||this.SUPPORTED_TYPES;t.isArray(s)||(s=s.replace(/s/g,"").split(","));for(var o,l,d=!1,u=0;u<s.length;u++)if(l=s[u],o="_"+l.toLowerCase(),d=d||this[o](n))return!0;return!1},_hex:function(t){return/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(t)},_hsl:function(t){return/^hsl\((\s*(-?\d+)\s*,)(\s*(\b(0?\d{1,2}|100)\b%)\s*,)(\s*(\b(0?\d{1,2}|100)\b%)\s*)\)$/.test(t)},_hsla:function(t){return/^hsla\((\s*(-?\d+)\s*,)(\s*(\b(0?\d{1,2}|100)\b%)\s*,){2}(\s*(0?(\.\d+)?|1(\.0+)?)\s*)\)$/.test(t)},_keyword:function(e){return t.inArray(e,this.KEYWORD_COLORS)>=0},_rgb:function(t){var e=/^rgb\((\s*(\b(0?\d{1,2}|100)\b%)\s*,){2}(\s*(\b(0?\d{1,2}|100)\b%)\s*)\)$/;return/^rgb\((\s*(\b([01]?\d{1,2}|2[0-4]\d|25[0-5])\b)\s*,){2}(\s*(\b([01]?\d{1,2}|2[0-4]\d|25[0-5])\b)\s*)\)$/.test(t)||e.test(t)},_rgba:function(t){var e=/^rgba\((\s*(\b(0?\d{1,2}|100)\b%)\s*,){3}(\s*(0?(\.\d+)?|1(\.0+)?)\s*)\)$/;return/^rgba\((\s*(\b([01]?\d{1,2}|2[0-4]\d|25[0-5])\b)\s*,){3}(\s*(0?(\.\d+)?|1(\.0+)?)\s*)\)$/.test(t)||e.test(t)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{creditCard:{default:"Please enter a valid credit card number"}}}),FormValidation.Validator.creditCard={validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;if(/[^0-9-\s]+/.test(n))return!1;if(n=n.replace(/\D/g,""),!FormValidation.Helper.luhn(n))return!1;var s,o,l={AMERICAN_EXPRESS:{length:[15],prefix:["34","37"]},DANKORT:{length:[16],prefix:["5019"]},DINERS_CLUB:{length:[14],prefix:["300","301","302","303","304","305","36"]},DINERS_CLUB_US:{length:[16],prefix:["54","55"]},DISCOVER:{length:[16],prefix:["6011","622126","622127","622128","622129","62213","62214","62215","62216","62217","62218","62219","6222","6223","6224","6225","6226","6227","6228","62290","62291","622920","622921","622922","622923","622924","622925","644","645","646","647","648","649","65"]},ELO:{length:[16],prefix:["4011","4312","4389","4514","4573","4576","5041","5066","5067","509","6277","6362","6363","650","6516","6550"]},FORBRUGSFORENINGEN:{length:[16],prefix:["600722"]},JCB:{length:[16],prefix:["3528","3529","353","354","355","356","357","358"]},LASER:{length:[16,17,18,19],prefix:["6304","6706","6771","6709"]},MAESTRO:{length:[12,13,14,15,16,17,18,19],prefix:["5018","5020","5038","5868","6304","6759","6761","6762","6763","6764","6765","6766"]},MASTERCARD:{length:[16],prefix:["51","52","53","54","55"]},SOLO:{length:[16,18,19],prefix:["6334","6767"]},UNIONPAY:{length:[16,17,18,19],prefix:["622126","622127","622128","622129","62213","62214","62215","62216","62217","62218","62219","6222","6223","6224","6225","6226","6227","6228","62290","62291","622920","622921","622922","622923","622924","622925"]},VISA_ELECTRON:{length:[16],prefix:["4026","417500","4405","4508","4844","4913","4917"]},VISA:{length:[16],prefix:["4"]}};for(s in l)for(o in l[s].prefix)if(n.substr(0,l[s].prefix[o].length)===l[s].prefix[o]&&-1!==t.inArray(n.length,l[s].length))return{valid:!0,type:s};return!1}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{cusip:{default:"Please enter a valid CUSIP number"}}}),FormValidation.Validator.cusip={validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;if(n=n.toUpperCase(),!/^[0-9A-Z]{9}$/.test(n))return!1;for(var s=t.map(n.split(""),function(t){var e=t.charCodeAt(0);return e>="A".charCodeAt(0)&&e<="Z".charCodeAt(0)?e-"A".charCodeAt(0)+10:t}),o=s.length,l=0,d=0;o-1>d;d++){var u=parseInt(s[d],10);d%2!=0&&(u*=2),u>9&&(u-=9),l+=u}return(l=(10-l%10)%10)===parseInt(s[o-1],10)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{cvv:{default:"Please enter a valid CVV number"}}}),FormValidation.Validator.cvv={html5Attributes:{message:"message",ccfield:"creditCardField"},init:function(t,e,a,i){if(a.creditCardField){var r=t.getFieldElements(a.creditCardField);t.onLiveChange(r,"live_"+i,function(){t.getStatus(e,i)!==t.STATUS_NOT_VALIDATED&&t.revalidateField(e)})}},destroy:function(t,e,a,i){if(a.creditCardField){var r=t.getFieldElements(a.creditCardField);t.offLiveChange(r,"live_"+i)}},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;if(!/^[0-9]{3,4}$/.test(n))return!1;if(!i.creditCardField)return!0;var s=e.getFieldValue(i.creditCardField,"creditCard");if(null===s||""===s)return!0;s=s.replace(/\D/g,"");var o,l,d={AMERICAN_EXPRESS:{length:[15],prefix:["34","37"]},DANKORT:{length:[16],prefix:["5019"]},DINERS_CLUB:{length:[14],prefix:["300","301","302","303","304","305","36"]},DINERS_CLUB_US:{length:[16],prefix:["54","55"]},DISCOVER:{length:[16],prefix:["6011","622126","622127","622128","622129","62213","62214","62215","62216","62217","62218","62219","6222","6223","6224","6225","6226","6227","6228","62290","62291","622920","622921","622922","622923","622924","622925","644","645","646","647","648","649","65"]},ELO:{length:[16],prefix:["4011","4312","4389","4514","4573","4576","5041","5066","5067","509","6277","6362","6363","650","6516","6550"]},FORBRUGSFORENINGEN:{length:[16],prefix:["600722"]},JCB:{length:[16],prefix:["3528","3529","353","354","355","356","357","358"]},LASER:{length:[16,17,18,19],prefix:["6304","6706","6771","6709"]},MAESTRO:{length:[12,13,14,15,16,17,18,19],prefix:["5018","5020","5038","5868","6304","6759","6761","6762","6763","6764","6765","6766"]},MASTERCARD:{length:[16],prefix:["51","52","53","54","55"]},SOLO:{length:[16,18,19],prefix:["6334","6767"]},UNIONPAY:{length:[16,17,18,19],prefix:["622126","622127","622128","622129","62213","62214","62215","62216","62217","62218","62219","6222","6223","6224","6225","6226","6227","6228","62290","62291","622920","622921","622922","622923","622924","622925"]},VISA_ELECTRON:{length:[16],prefix:["4026","417500","4405","4508","4844","4913","4917"]},VISA:{length:[16],prefix:["4"]}},u=null;for(o in d)for(l in d[o].prefix)if(s.substr(0,d[o].prefix[l].length)===d[o].prefix[l]&&-1!==t.inArray(s.length,d[o].length)){u=o;break}return null!==u&&("AMERICAN_EXPRESS"===u?4===n.length:3===n.length)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{date:{default:"Please enter a valid date",min:"Please enter a date after %s",max:"Please enter a date before %s",range:"Please enter a date in the range %s - %s"}}}),FormValidation.Validator.date={html5Attributes:{message:"message",format:"format",min:"min",max:"max",separator:"separator"},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;i.format=i.format||"MM/DD/YYYY","date"===a.attr("type")&&(i.format="YYYY-MM-DD");var s=e.getLocale(),o=i.message||FormValidation.I18n[s].date.default,l=i.format.split(" "),d=l[0],u=l.length>1?l[1]:null,f=l.length>2?l[2]:null,c=n.split(" "),h=c[0],p=c.length>1?c[1]:null;if(l.length!==c.length)return{valid:!1,message:o};var m=i.separator;if(m||(m=-1!==h.indexOf("/")?"/":-1!==h.indexOf("-")?"-":-1!==h.indexOf(".")?".":null),null===m||-1===h.indexOf(m))return{valid:!1,message:o};if(h=h.split(m),d=d.split(m),h.length!==d.length)return{valid:!1,message:o};var v=h[t.inArray("YYYY",d)],g=h[t.inArray("MM",d)],A=h[t.inArray("DD",d)];if(!v||!g||!A||4!==v.length)return{valid:!1,message:o};var I=null,b=null,F=null;if(u){if(u=u.split(":"),p=p.split(":"),u.length!==p.length)return{valid:!1,message:o};if(b=p.length>0?p[0]:null,I=p.length>1?p[1]:null,F=p.length>2?p[2]:null,""===b||""===I||""===F)return{valid:!1,message:o};if(F){if(isNaN(F)||F.length>2)return{valid:!1,message:o};if(0>(F=parseInt(F,10))||F>60)return{valid:!1,message:o}}if(b){if(isNaN(b)||b.length>2)return{valid:!1,message:o};if(0>(b=parseInt(b,10))||b>=24||f&&b>12)return{valid:!1,message:o}}if(I){if(isNaN(I)||I.length>2)return{valid:!1,message:o};if(0>(I=parseInt(I,10))||I>59)return{valid:!1,message:o}}}var V=FormValidation.Helper.date(v,g,A),S=null,E=null,T=i.min,_=i.max;switch(T&&(S=T instanceof Date?T:this._parseDate(T,d,m)||this._parseDate(e.getDynamicOption(a,T),d,m),T=this._formatDate(S,i.format)),_&&(E=_ instanceof Date?_:this._parseDate(_,d,m)||this._parseDate(e.getDynamicOption(a,_),d,m),_=this._formatDate(E,i.format)),h=new Date(v,g-1,A,b,I,F),!0){case T&&!_&&V:V=h.getTime()>=S.getTime(),o=i.message||FormValidation.Helper.format(FormValidation.I18n[s].date.min,T);break;case _&&!T&&V:V=h.getTime()<=E.getTime(),o=i.message||FormValidation.Helper.format(FormValidation.I18n[s].date.max,_);break;case _&&T&&V:V=h.getTime()<=E.getTime()&&h.getTime()>=S.getTime(),o=i.message||FormValidation.Helper.format(FormValidation.I18n[s].date.range,[T,_])}return{valid:V,date:h,message:o}},_parseDate:function(e,a,i){if(e instanceof Date)return e;if("string"!=typeof e)return null;var r=t.inArray("YYYY",a),n=t.inArray("MM",a),s=t.inArray("DD",a);if(-1===r||-1===n||-1===s)return null;var o=0,l=0,d=0,u=e.split(" "),f=u[0].split(i);if(f.length<3)return null;if(u.length>1){var c=u[1].split(":");l=c.length>0?c[0]:null,o=c.length>1?c[1]:null,d=c.length>2?c[2]:null}return new Date(f[r],f[n]-1,f[s],l,o,d)},_formatDate:function(t,e){var a={d:function(t){return t.getDate()},dd:function(t){var e=t.getDate();return 10>e?"0"+e:e},m:function(t){return t.getMonth()+1},mm:function(t){var e=t.getMonth()+1;return 10>e?"0"+e:e},yy:function(t){return(""+t.getFullYear()).substr(2)},yyyy:function(t){return t.getFullYear()},h:function(t){return t.getHours()%12||12},hh:function(t){var e=t.getHours()%12||12;return 10>e?"0"+e:e},H:function(t){return t.getHours()},HH:function(t){var e=t.getHours();return 10>e?"0"+e:e},M:function(t){return t.getMinutes()},MM:function(t){var e=t.getMinutes();return 10>e?"0"+e:e},s:function(t){return t.getSeconds()},ss:function(t){var e=t.getSeconds();return 10>e?"0"+e:e}};return(e=e.replace(/Y/g,"y").replace(/M/g,"m").replace(/D/g,"d").replace(/:m/g,":M").replace(/:mm/g,":MM").replace(/:S/,":s").replace(/:SS/,":ss")).replace(/d{1,4}|m{1,4}|yy(?:yy)?|([HhMs])\1?|"[^"]*"|'[^']*'/g,function(e){return a[e]?a[e](t):e.slice(1,e.length-1)})}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{different:{default:"Please enter a different value"}}}),FormValidation.Validator.different={html5Attributes:{message:"message",field:"field"},init:function(e,a,i,r){for(var n=i.field.split(","),s=0;s<n.length;s++){var o=e.getFieldElements(t.trim(n[s]));e.onLiveChange(o,"live_"+r,function(){e.getStatus(a,r)!==e.STATUS_NOT_VALIDATED&&e.revalidateField(a)})}},destroy:function(e,a,i,r){for(var n=i.field.split(","),s=0;s<n.length;s++){var o=e.getFieldElements(t.trim(n[s]));e.offLiveChange(o,"live_"+r)}},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;for(var s=i.field.split(","),o=!0,l=0;l<s.length;l++){var d=e.getFieldElements(t.trim(s[l]));if(null!=d&&0!==d.length){var u=e.getFieldValue(d,r);n===u?o=!1:""!==u&&e.updateStatus(d,e.STATUS_VALID,r)}}return o}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{digits:{default:"Please enter only digits"}}}),FormValidation.Validator.digits={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);return""===r||/^\d+$/.test(r)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{ean:{default:"Please enter a valid EAN number"}}}),FormValidation.Validator.ean={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;if(!/^(\d{8}|\d{12}|\d{13})$/.test(r))return!1;for(var n=r.length,s=0,o=8===n?[3,1]:[1,3],l=0;n-1>l;l++)s+=parseInt(r.charAt(l),10)*o[l%2];return(s=(10-s%10)%10)+""===r.charAt(n-1)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{ein:{default:"Please enter a valid EIN number"}}}),FormValidation.Validator.ein={CAMPUS:{ANDOVER:["10","12"],ATLANTA:["60","67"],AUSTIN:["50","53"],BROOKHAVEN:["01","02","03","04","05","06","11","13","14","16","21","22","23","25","34","51","52","54","55","56","57","58","59","65"],CINCINNATI:["30","32","35","36","37","38","61"],FRESNO:["15","24"],KANSAS_CITY:["40","44"],MEMPHIS:["94","95"],OGDEN:["80","90"],PHILADELPHIA:["33","39","41","42","43","48","62","63","64","66","68","71","72","73","74","75","76","77","81","82","83","84","85","86","87","88","91","92","93","98","99"],INTERNET:["20","26","27","45","46","47"],SMALL_BUSINESS_ADMINISTRATION:["31"]},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;if(!/^[0-9]{2}-?[0-9]{7}$/.test(n))return!1;var s=n.substr(0,2)+"";for(var o in this.CAMPUS)if(-1!==t.inArray(s,this.CAMPUS[o]))return{valid:!0,campus:o};return!1}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{emailAddress:{default:"Please enter a valid email address"}}}),FormValidation.Validator.emailAddress={html5Attributes:{message:"message",multiple:"multiple",separator:"separator"},enableByHtml5:function(t){return"email"===t.attr("type")},validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;var n=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;if(!0===a.multiple||"true"===a.multiple){for(var s=a.separator||/[,;]/,o=this._splitEmailAddresses(r,s),l=0;l<o.length;l++)if(!n.test(o[l]))return!1;return!0}return n.test(r)},_splitEmailAddresses:function(t,e){for(var a=t.split(/"/),i=a.length,r=[],n="",s=0;i>s;s++)if(s%2==0){var o=a[s].split(e),l=o.length;if(1===l)n+=o[0];else{r.push(n+o[0]);for(var d=1;l-1>d;d++)r.push(o[d]);n=o[l-1]}}else n+='"'+a[s],i-1>s&&(n+='"');return r.push(n),r}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{file:{default:"Please choose a valid file"}}}),FormValidation.Validator.file={Error:{EXTENSION:"EXTENSION",MAX_FILES:"MAX_FILES",MAX_SIZE:"MAX_SIZE",MAX_TOTAL_SIZE:"MAX_TOTAL_SIZE",MIN_FILES:"MIN_FILES",MIN_SIZE:"MIN_SIZE",MIN_TOTAL_SIZE:"MIN_TOTAL_SIZE",TYPE:"TYPE"},html5Attributes:{extension:"extension",maxfiles:"maxFiles",minfiles:"minFiles",maxsize:"maxSize",minsize:"minSize",maxtotalsize:"maxTotalSize",mintotalsize:"minTotalSize",message:"message",type:"type"},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;var s,o=i.extension?i.extension.toLowerCase().split(","):null,l=i.type?i.type.toLowerCase().split(","):null;if(window.File&&window.FileList&&window.FileReader){var d=a.get(0).files,u=d.length,f=0;if(i.maxFiles&&u>parseInt(i.maxFiles,10))return{valid:!1,error:this.Error.MAX_FILES};if(i.minFiles&&u<parseInt(i.minFiles,10))return{valid:!1,error:this.Error.MIN_FILES};for(var c={},h=0;u>h;h++){if(f+=d[h].size,s=d[h].name.substr(d[h].name.lastIndexOf(".")+1),c={file:d[h],size:d[h].size,ext:s,type:d[h].type},i.minSize&&d[h].size<parseInt(i.minSize,10))return{valid:!1,error:this.Error.MIN_SIZE,metaData:c};if(i.maxSize&&d[h].size>parseInt(i.maxSize,10))return{valid:!1,error:this.Error.MAX_SIZE,metaData:c};if(o&&-1===t.inArray(s.toLowerCase(),o))return{valid:!1,error:this.Error.EXTENSION,metaData:c};if(d[h].type&&l&&-1===t.inArray(d[h].type.toLowerCase(),l))return{valid:!1,error:this.Error.TYPE,metaData:c}}if(i.maxTotalSize&&f>parseInt(i.maxTotalSize,10))return{valid:!1,error:this.Error.MAX_TOTAL_SIZE,metaData:{totalSize:f}};if(i.minTotalSize&&f<parseInt(i.minTotalSize,10))return{valid:!1,error:this.Error.MIN_TOTAL_SIZE,metaData:{totalSize:f}}}else if(s=n.substr(n.lastIndexOf(".")+1),o&&-1===t.inArray(s.toLowerCase(),o))return{valid:!1,error:this.Error.EXTENSION,metaData:{ext:s}};return!0}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{greaterThan:{default:"Please enter a value greater than or equal to %s",notInclusive:"Please enter a value greater than %s"}}}),FormValidation.Validator.greaterThan={html5Attributes:{message:"message",value:"value",inclusive:"inclusive"},enableByHtml5:function(t){var e=t.attr("type"),a=t.attr("min");return!(!a||"date"===e)&&{value:a}},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;n=this._format(n);var s=e.getLocale(),o=t.isNumeric(i.value)?i.value:e.getDynamicOption(a,i.value),l=this._format(o);return!0===i.inclusive||void 0===i.inclusive?{valid:t.isNumeric(n)&&parseFloat(n)>=l,message:FormValidation.Helper.format(i.message||FormValidation.I18n[s].greaterThan.default,o)}:{valid:t.isNumeric(n)&&parseFloat(n)>l,message:FormValidation.Helper.format(i.message||FormValidation.I18n[s].greaterThan.notInclusive,o)}},_format:function(t){return(t+"").replace(",",".")}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{grid:{default:"Please enter a valid GRId number"}}}),FormValidation.Validator.grid={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);return""===r||(r=r.toUpperCase(),!!/^[GRID:]*([0-9A-Z]{2})[-\s]*([0-9A-Z]{5})[-\s]*([0-9A-Z]{10})[-\s]*([0-9A-Z]{1})$/g.test(r)&&("GRID:"===(r=r.replace(/\s/g,"").replace(/-/g,"")).substr(0,5)&&(r=r.substr(5)),FormValidation.Helper.mod37And36(r)))}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{hex:{default:"Please enter a valid hexadecimal number"}}}),FormValidation.Validator.hex={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);return""===r||/^[0-9a-fA-F]+$/.test(r)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{iban:{default:"Please enter a valid IBAN number",country:"Please enter a valid IBAN number in %s",countries:{AD:"Andorra",AE:"United Arab Emirates",AL:"Albania",AO:"Angola",AT:"Austria",AZ:"Azerbaijan",BA:"Bosnia and Herzegovina",BE:"Belgium",BF:"Burkina Faso",BG:"Bulgaria",BH:"Bahrain",BI:"Burundi",BJ:"Benin",BR:"Brazil",CH:"Switzerland",CI:"Ivory Coast",CM:"Cameroon",CR:"Costa Rica",CV:"Cape Verde",CY:"Cyprus",CZ:"Czech Republic",DE:"Germany",DK:"Denmark",DO:"Dominican Republic",DZ:"Algeria",EE:"Estonia",ES:"Spain",FI:"Finland",FO:"Faroe Islands",FR:"France",GB:"United Kingdom",GE:"Georgia",GI:"Gibraltar",GL:"Greenland",GR:"Greece",GT:"Guatemala",HR:"Croatia",HU:"Hungary",IE:"Ireland",IL:"Israel",IR:"Iran",IS:"Iceland",IT:"Italy",JO:"Jordan",KW:"Kuwait",KZ:"Kazakhstan",LB:"Lebanon",LI:"Liechtenstein",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",MC:"Monaco",MD:"Moldova",ME:"Montenegro",MG:"Madagascar",MK:"Macedonia",ML:"Mali",MR:"Mauritania",MT:"Malta",MU:"Mauritius",MZ:"Mozambique",NL:"Netherlands",NO:"Norway",PK:"Pakistan",PL:"Poland",PS:"Palestine",PT:"Portugal",QA:"Qatar",RO:"Romania",RS:"Serbia",SA:"Saudi Arabia",SE:"Sweden",SI:"Slovenia",SK:"Slovakia",SM:"San Marino",SN:"Senegal",TL:"East Timor",TN:"Tunisia",TR:"Turkey",VG:"Virgin Islands, British",XK:"Republic of Kosovo"}}}}),FormValidation.Validator.iban={html5Attributes:{message:"message",country:"country",sepa:"sepa"},REGEX:{AD:"AD[0-9]{2}[0-9]{4}[0-9]{4}[A-Z0-9]{12}",AE:"AE[0-9]{2}[0-9]{3}[0-9]{16}",AL:"AL[0-9]{2}[0-9]{8}[A-Z0-9]{16}",AO:"AO[0-9]{2}[0-9]{21}",AT:"AT[0-9]{2}[0-9]{5}[0-9]{11}",AZ:"AZ[0-9]{2}[A-Z]{4}[A-Z0-9]{20}",BA:"BA[0-9]{2}[0-9]{3}[0-9]{3}[0-9]{8}[0-9]{2}",BE:"BE[0-9]{2}[0-9]{3}[0-9]{7}[0-9]{2}",BF:"BF[0-9]{2}[0-9]{23}",BG:"BG[0-9]{2}[A-Z]{4}[0-9]{4}[0-9]{2}[A-Z0-9]{8}",BH:"BH[0-9]{2}[A-Z]{4}[A-Z0-9]{14}",BI:"BI[0-9]{2}[0-9]{12}",BJ:"BJ[0-9]{2}[A-Z]{1}[0-9]{23}",BR:"BR[0-9]{2}[0-9]{8}[0-9]{5}[0-9]{10}[A-Z][A-Z0-9]",CH:"CH[0-9]{2}[0-9]{5}[A-Z0-9]{12}",CI:"CI[0-9]{2}[A-Z]{1}[0-9]{23}",CM:"CM[0-9]{2}[0-9]{23}",CR:"CR[0-9]{2}[0-9]{3}[0-9]{14}",CV:"CV[0-9]{2}[0-9]{21}",CY:"CY[0-9]{2}[0-9]{3}[0-9]{5}[A-Z0-9]{16}",CZ:"CZ[0-9]{2}[0-9]{20}",DE:"DE[0-9]{2}[0-9]{8}[0-9]{10}",DK:"DK[0-9]{2}[0-9]{14}",DO:"DO[0-9]{2}[A-Z0-9]{4}[0-9]{20}",DZ:"DZ[0-9]{2}[0-9]{20}",EE:"EE[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{11}[0-9]{1}",ES:"ES[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{1}[0-9]{1}[0-9]{10}",FI:"FI[0-9]{2}[0-9]{6}[0-9]{7}[0-9]{1}",FO:"FO[0-9]{2}[0-9]{4}[0-9]{9}[0-9]{1}",FR:"FR[0-9]{2}[0-9]{5}[0-9]{5}[A-Z0-9]{11}[0-9]{2}",GB:"GB[0-9]{2}[A-Z]{4}[0-9]{6}[0-9]{8}",GE:"GE[0-9]{2}[A-Z]{2}[0-9]{16}",GI:"GI[0-9]{2}[A-Z]{4}[A-Z0-9]{15}",GL:"GL[0-9]{2}[0-9]{4}[0-9]{9}[0-9]{1}",GR:"GR[0-9]{2}[0-9]{3}[0-9]{4}[A-Z0-9]{16}",GT:"GT[0-9]{2}[A-Z0-9]{4}[A-Z0-9]{20}",HR:"HR[0-9]{2}[0-9]{7}[0-9]{10}",HU:"HU[0-9]{2}[0-9]{3}[0-9]{4}[0-9]{1}[0-9]{15}[0-9]{1}",IE:"IE[0-9]{2}[A-Z]{4}[0-9]{6}[0-9]{8}",IL:"IL[0-9]{2}[0-9]{3}[0-9]{3}[0-9]{13}",IR:"IR[0-9]{2}[0-9]{22}",IS:"IS[0-9]{2}[0-9]{4}[0-9]{2}[0-9]{6}[0-9]{10}",IT:"IT[0-9]{2}[A-Z]{1}[0-9]{5}[0-9]{5}[A-Z0-9]{12}",JO:"JO[0-9]{2}[A-Z]{4}[0-9]{4}[0]{8}[A-Z0-9]{10}",KW:"KW[0-9]{2}[A-Z]{4}[0-9]{22}",KZ:"KZ[0-9]{2}[0-9]{3}[A-Z0-9]{13}",LB:"LB[0-9]{2}[0-9]{4}[A-Z0-9]{20}",LI:"LI[0-9]{2}[0-9]{5}[A-Z0-9]{12}",LT:"LT[0-9]{2}[0-9]{5}[0-9]{11}",LU:"LU[0-9]{2}[0-9]{3}[A-Z0-9]{13}",LV:"LV[0-9]{2}[A-Z]{4}[A-Z0-9]{13}",MC:"MC[0-9]{2}[0-9]{5}[0-9]{5}[A-Z0-9]{11}[0-9]{2}",MD:"MD[0-9]{2}[A-Z0-9]{20}",ME:"ME[0-9]{2}[0-9]{3}[0-9]{13}[0-9]{2}",MG:"MG[0-9]{2}[0-9]{23}",MK:"MK[0-9]{2}[0-9]{3}[A-Z0-9]{10}[0-9]{2}",ML:"ML[0-9]{2}[A-Z]{1}[0-9]{23}",MR:"MR13[0-9]{5}[0-9]{5}[0-9]{11}[0-9]{2}",MT:"MT[0-9]{2}[A-Z]{4}[0-9]{5}[A-Z0-9]{18}",MU:"MU[0-9]{2}[A-Z]{4}[0-9]{2}[0-9]{2}[0-9]{12}[0-9]{3}[A-Z]{3}",MZ:"MZ[0-9]{2}[0-9]{21}",NL:"NL[0-9]{2}[A-Z]{4}[0-9]{10}",NO:"NO[0-9]{2}[0-9]{4}[0-9]{6}[0-9]{1}",PK:"PK[0-9]{2}[A-Z]{4}[A-Z0-9]{16}",PL:"PL[0-9]{2}[0-9]{8}[0-9]{16}",PS:"PS[0-9]{2}[A-Z]{4}[A-Z0-9]{21}",PT:"PT[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{11}[0-9]{2}",QA:"QA[0-9]{2}[A-Z]{4}[A-Z0-9]{21}",RO:"RO[0-9]{2}[A-Z]{4}[A-Z0-9]{16}",RS:"RS[0-9]{2}[0-9]{3}[0-9]{13}[0-9]{2}",SA:"SA[0-9]{2}[0-9]{2}[A-Z0-9]{18}",SE:"SE[0-9]{2}[0-9]{3}[0-9]{16}[0-9]{1}",SI:"SI[0-9]{2}[0-9]{5}[0-9]{8}[0-9]{2}",SK:"SK[0-9]{2}[0-9]{4}[0-9]{6}[0-9]{10}",SM:"SM[0-9]{2}[A-Z]{1}[0-9]{5}[0-9]{5}[A-Z0-9]{12}",SN:"SN[0-9]{2}[A-Z]{1}[0-9]{23}",TL:"TL38[0-9]{3}[0-9]{14}[0-9]{2}",TN:"TN59[0-9]{2}[0-9]{3}[0-9]{13}[0-9]{2}",TR:"TR[0-9]{2}[0-9]{5}[A-Z0-9]{1}[A-Z0-9]{16}",VG:"VG[0-9]{2}[A-Z]{4}[0-9]{16}",XK:"XK[0-9]{2}[0-9]{4}[0-9]{10}[0-9]{2}"},SEPA_COUNTRIES:["AT","BE","BG","CH","CY","CZ","DE","DK","EE","ES","FI","FR","GB","GI","GR","HR","HU","IE","IS","IT","LI","LT","LU","LV","MC","MT","NL","NO","PL","PT","RO","SE","SI","SK","SM"],validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;n=n.replace(/[^a-zA-Z0-9]/g,"").toUpperCase();var s=i.country;s?"string"==typeof s&&this.REGEX[s]||(s=e.getDynamicOption(a,s)):s=n.substr(0,2);var o=e.getLocale();if(!this.REGEX[s])return!1;if(void 0!==typeof i.sepa){var l=-1!==t.inArray(s,this.SEPA_COUNTRIES);if(("true"===i.sepa||!0===i.sepa)&&!l||("false"===i.sepa||!1===i.sepa)&&l)return!1}if(!new RegExp("^"+this.REGEX[s]+"$").test(n))return{valid:!1,message:FormValidation.Helper.format(i.message||FormValidation.I18n[o].iban.country,FormValidation.I18n[o].iban.countries[s])};n=n.substr(4)+n.substr(0,4),n=(n=t.map(n.split(""),function(t){var e=t.charCodeAt(0);return e>="A".charCodeAt(0)&&e<="Z".charCodeAt(0)?e-"A".charCodeAt(0)+10:t})).join("");for(var d=parseInt(n.substr(0,1),10),u=n.length,f=1;u>f;++f)d=(10*d+parseInt(n.substr(f,1),10))%97;return{valid:1===d,message:FormValidation.Helper.format(i.message||FormValidation.I18n[o].iban.country,FormValidation.I18n[o].iban.countries[s])}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{id:{default:"Please enter a valid identification number",country:"Please enter a valid identification number in %s",countries:{BA:"Bosnia and Herzegovina",BG:"Bulgaria",BR:"Brazil",CH:"Switzerland",CL:"Chile",CN:"China",CZ:"Czech Republic",DK:"Denmark",EE:"Estonia",ES:"Spain",FI:"Finland",HR:"Croatia",IE:"Ireland",IS:"Iceland",LT:"Lithuania",LV:"Latvia",ME:"Montenegro",MK:"Macedonia",NL:"Netherlands",PL:"Poland",RO:"Romania",RS:"Serbia",SE:"Sweden",SI:"Slovenia",SK:"Slovakia",SM:"San Marino",TH:"Thailand",TR:"Turkey",ZA:"South Africa"}}}}),FormValidation.Validator.id={html5Attributes:{message:"message",country:"country"},COUNTRY_CODES:["BA","BG","BR","CH","CL","CN","CZ","DK","EE","ES","FI","HR","IE","IS","LT","LV","ME","MK","NL","PL","RO","RS","SE","SI","SK","SM","TH","TR","ZA"],validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;var s=e.getLocale(),o=i.country;if(o?("string"!=typeof o||-1===t.inArray(o.toUpperCase(),this.COUNTRY_CODES))&&(o=e.getDynamicOption(a,o)):o=n.substr(0,2),-1===t.inArray(o,this.COUNTRY_CODES))return!0;var l=this[["_",o.toLowerCase()].join("")](n);return l=!0===l||!1===l?{valid:l}:l,l.message=FormValidation.Helper.format(i.message||FormValidation.I18n[s].id.country,FormValidation.I18n[s].id.countries[o.toUpperCase()]),l},_validateJMBG:function(t,e){if(!/^\d{13}$/.test(t))return!1;var a=parseInt(t.substr(0,2),10),i=parseInt(t.substr(2,2),10),r=(parseInt(t.substr(4,3),10),parseInt(t.substr(7,2),10)),n=parseInt(t.substr(12,1),10);if(a>31||i>12)return!1;for(var s=0,o=0;6>o;o++)s+=(7-o)*(parseInt(t.charAt(o),10)+parseInt(t.charAt(o+6),10));if((10===(s=11-s%11)||11===s)&&(s=0),s!==n)return!1;switch(e.toUpperCase()){case"BA":return r>=10&&19>=r;case"MK":return r>=41&&49>=r;case"ME":return r>=20&&29>=r;case"RS":return r>=70&&99>=r;case"SI":return r>=50&&59>=r;default:return!0}},_ba:function(t){return this._validateJMBG(t,"BA")},_mk:function(t){return this._validateJMBG(t,"MK")},_me:function(t){return this._validateJMBG(t,"ME")},_rs:function(t){return this._validateJMBG(t,"RS")},_si:function(t){return this._validateJMBG(t,"SI")},_bg:function(t){if(!/^\d{10}$/.test(t)&&!/^\d{6}\s\d{3}\s\d{1}$/.test(t))return!1;t=t.replace(/\s/g,"");var e=parseInt(t.substr(0,2),10)+1900,a=parseInt(t.substr(2,2),10),i=parseInt(t.substr(4,2),10);if(a>40?(e+=100,a-=40):a>20&&(e-=100,a-=20),!FormValidation.Helper.date(e,a,i))return!1;for(var r=0,n=[2,4,8,5,10,9,7,3,6],s=0;9>s;s++)r+=parseInt(t.charAt(s),10)*n[s];return(r=r%11%10)+""===t.substr(9,1)},_br:function(t){if(t=t.replace(/\D/g,""),!/^\d{11}$/.test(t)||/^1{11}|2{11}|3{11}|4{11}|5{11}|6{11}|7{11}|8{11}|9{11}|0{11}$/.test(t))return!1;for(var e=0,a=0;9>a;a++)e+=(10-a)*parseInt(t.charAt(a),10);if((10===(e=11-e%11)||11===e)&&(e=0),e+""!==t.charAt(9))return!1;var i=0;for(a=0;10>a;a++)i+=(11-a)*parseInt(t.charAt(a),10);return(10===(i=11-i%11)||11===i)&&(i=0),i+""===t.charAt(10)},_ch:function(t){if(!/^756[\.]{0,1}[0-9]{4}[\.]{0,1}[0-9]{4}[\.]{0,1}[0-9]{2}$/.test(t))return!1;for(var e=(t=t.replace(/\D/g,"").substr(3)).length,a=0,i=8===e?[3,1]:[1,3],r=0;e-1>r;r++)a+=parseInt(t.charAt(r),10)*i[r%2];return(a=10-a%10)+""===t.charAt(e-1)},_cl:function(t){if(!/^\d{7,8}[-]{0,1}[0-9K]$/i.test(t))return!1;for(t=t.replace(/\-/g,"");t.length<9;)t="0"+t;for(var e=0,a=[3,2,7,6,5,4,3,2],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return e=11-e%11,11===e?e=0:10===e&&(e="K"),e+""===t.charAt(8).toUpperCase()},_cn:function(e){if(e=e.trim(),!/^\d{15}$/.test(e)&&!/^\d{17}[\dXx]{1}$/.test(e))return!1;var a={11:{0:[0],1:[[0,9],[11,17]],2:[0,28,29]},12:{0:[0],1:[[0,16]],2:[0,21,23,25]},13:{0:[0],1:[[0,5],7,8,21,[23,33],[81,85]],2:[[0,5],[7,9],[23,25],27,29,30,81,83],3:[[0,4],[21,24]],4:[[0,4],6,21,[23,35],81],5:[[0,3],[21,35],81,82],6:[[0,4],[21,38],[81,84]],7:[[0,3],5,6,[21,33]],8:[[0,4],[21,28]],9:[[0,3],[21,30],[81,84]],10:[[0,3],[22,26],28,81,82],11:[[0,2],[21,28],81,82]},14:{0:[0],1:[0,1,[5,10],[21,23],81],2:[[0,3],11,12,[21,27]],3:[[0,3],11,21,22],4:[[0,2],11,21,[23,31],81],5:[[0,2],21,22,24,25,81],6:[[0,3],[21,24]],7:[[0,2],[21,29],81],8:[[0,2],[21,30],81,82],9:[[0,2],[21,32],81],10:[[0,2],[21,34],81,82],11:[[0,2],[21,30],81,82],23:[[0,3],22,23,[25,30],32,33]},15:{0:[0],1:[[0,5],[21,25]],2:[[0,7],[21,23]],3:[[0,4]],4:[[0,4],[21,26],[28,30]],5:[[0,2],[21,26],81],6:[[0,2],[21,27]],7:[[0,3],[21,27],[81,85]],8:[[0,2],[21,26]],9:[[0,2],[21,29],81],22:[[0,2],[21,24]],25:[[0,2],[22,31]],26:[[0,2],[24,27],[29,32],34],28:[0,1,[22,27]],29:[0,[21,23]]},21:{0:[0],1:[[0,6],[11,14],[22,24],81],2:[[0,4],[11,13],24,[81,83]],3:[[0,4],11,21,23,81],4:[[0,4],11,[21,23]],5:[[0,5],21,22],6:[[0,4],24,81,82],7:[[0,3],11,26,27,81,82],8:[[0,4],11,81,82],9:[[0,5],11,21,22],10:[[0,5],11,21,81],11:[[0,3],21,22],12:[[0,2],4,21,23,24,81,82],13:[[0,3],21,22,24,81,82],14:[[0,4],21,22,81]},22:{0:[0],1:[[0,6],12,22,[81,83]],2:[[0,4],11,21,[81,84]],3:[[0,3],22,23,81,82],4:[[0,3],21,22],5:[[0,3],21,23,24,81,82],6:[[0,2],4,5,[21,23],25,81],7:[[0,2],[21,24],81],8:[[0,2],21,22,81,82],24:[[0,6],24,26]},23:{0:[0],1:[[0,12],21,[23,29],[81,84]],2:[[0,8],21,[23,25],27,[29,31],81],3:[[0,7],21,81,82],4:[[0,7],21,22],5:[[0,3],5,6,[21,24]],6:[[0,6],[21,24]],7:[[0,16],22,81],8:[[0,5],11,22,26,28,33,81,82],9:[[0,4],21],10:[[0,5],24,25,81,[83,85]],11:[[0,2],21,23,24,81,82],12:[[0,2],[21,26],[81,83]],27:[[0,4],[21,23]]},31:{0:[0],1:[0,1,[3,10],[12,20]],2:[0,30]},32:{0:[0],1:[[0,7],11,[13,18],24,25],2:[[0,6],11,81,82],3:[[0,5],11,12,[21,24],81,82],4:[[0,2],4,5,11,12,81,82],5:[[0,9],[81,85]],6:[[0,2],11,12,21,23,[81,84]],7:[0,1,3,5,6,[21,24]],8:[[0,4],11,26,[29,31]],9:[[0,3],[21,25],28,81,82],10:[[0,3],11,12,23,81,84,88],11:[[0,2],11,12,[81,83]],12:[[0,4],[81,84]],13:[[0,2],11,[21,24]]},33:{0:[0],1:[[0,6],[8,10],22,27,82,83,85],2:[0,1,[3,6],11,12,25,26,[81,83]],3:[[0,4],22,24,[26,29],81,82],4:[[0,2],11,21,24,[81,83]],5:[[0,3],[21,23]],6:[[0,2],21,24,[81,83]],7:[[0,3],23,26,27,[81,84]],8:[[0,3],22,24,25,81],9:[[0,3],21,22],10:[[0,4],[21,24],81,82],11:[[0,2],[21,27],81]},34:{0:[0],1:[[0,4],11,[21,24],81],2:[[0,4],7,8,[21,23],25],3:[[0,4],11,[21,23]],4:[[0,6],21],5:[[0,4],6,[21,23]],6:[[0,4],21],7:[[0,3],11,21],8:[[0,3],11,[22,28],81],10:[[0,4],[21,24]],11:[[0,3],22,[24,26],81,82],12:[[0,4],21,22,25,26,82],13:[[0,2],[21,24]],14:[[0,2],[21,24]],15:[[0,3],[21,25]],16:[[0,2],[21,23]],17:[[0,2],[21,23]],18:[[0,2],[21,25],81]},35:{0:[0],1:[[0,5],11,[21,25],28,81,82],2:[[0,6],[11,13]],3:[[0,5],22],4:[[0,3],21,[23,30],81],5:[[0,5],21,[24,27],[81,83]],6:[[0,3],[22,29],81],7:[[0,2],[21,25],[81,84]],8:[[0,2],[21,25],81],9:[[0,2],[21,26],81,82]},36:{0:[0],1:[[0,5],11,[21,24]],2:[[0,3],22,81],3:[[0,2],13,[21,23]],4:[[0,3],21,[23,30],81,82],5:[[0,2],21],6:[[0,2],22,81],7:[[0,2],[21,35],81,82],8:[[0,3],[21,30],81],9:[[0,2],[21,26],[81,83]],10:[[0,2],[21,30]],11:[[0,2],[21,30],81]},37:{0:[0],1:[[0,5],12,13,[24,26],81],2:[[0,3],5,[11,14],[81,85]],3:[[0,6],[21,23]],4:[[0,6],81],5:[[0,3],[21,23]],6:[[0,2],[11,13],34,[81,87]],7:[[0,5],24,25,[81,86]],8:[[0,2],11,[26,32],[81,83]],9:[[0,3],11,21,23,82,83],10:[[0,2],[81,83]],11:[[0,3],21,22],12:[[0,3]],13:[[0,2],11,12,[21,29]],14:[[0,2],[21,28],81,82],15:[[0,2],[21,26],81],16:[[0,2],[21,26]],17:[[0,2],[21,28]]},41:{0:[0],1:[[0,6],8,22,[81,85]],2:[[0,5],11,[21,25]],3:[[0,7],11,[22,29],81],4:[[0,4],11,[21,23],25,81,82],5:[[0,3],5,6,22,23,26,27,81],6:[[0,3],11,21,22],7:[[0,4],11,21,[24,28],81,82],8:[[0,4],11,[21,23],25,[81,83]],9:[[0,2],22,23,[26,28]],10:[[0,2],[23,25],81,82],11:[[0,4],[21,23]],12:[[0,2],21,22,24,81,82],13:[[0,3],[21,30],81],14:[[0,3],[21,26],81],15:[[0,3],[21,28]],16:[[0,2],[21,28],81],17:[[0,2],[21,29]],90:[0,1]},42:{0:[0],1:[[0,7],[11,17]],2:[[0,5],22,81],3:[[0,3],[21,25],81],5:[[0,6],[25,29],[81,83]],6:[[0,2],6,7,[24,26],[82,84]],7:[[0,4]],8:[[0,2],4,21,22,81],9:[[0,2],[21,23],81,82,84],10:[[0,3],[22,24],81,83,87],11:[[0,2],[21,27],81,82],12:[[0,2],[21,24],81],13:[[0,3],21,81],28:[[0,2],22,23,[25,28]],90:[0,[4,6],21]},43:{0:[0],1:[[0,5],11,12,21,22,24,81],2:[[0,4],11,21,[23,25],81],3:[[0,2],4,21,81,82],4:[0,1,[5,8],12,[21,24],26,81,82],5:[[0,3],11,[21,25],[27,29],81],6:[[0,3],11,21,23,24,26,81,82],7:[[0,3],[21,26],81],8:[[0,2],11,21,22],9:[[0,3],[21,23],81],10:[[0,3],[21,28],81],11:[[0,3],[21,29]],12:[[0,2],[21,30],81],13:[[0,2],21,22,81,82],31:[0,1,[22,27],30]},44:{0:[0],1:[[0,7],[11,16],83,84],2:[[0,5],21,22,24,29,32,33,81,82],3:[0,1,[3,8]],4:[[0,4]],5:[0,1,[6,15],23,82,83],6:[0,1,[4,8]],7:[0,1,[3,5],81,[83,85]],8:[[0,4],11,23,25,[81,83]],9:[[0,3],23,[81,83]],12:[[0,3],[23,26],83,84],13:[[0,3],[22,24],81],14:[[0,2],[21,24],26,27,81],15:[[0,2],21,23,81],16:[[0,2],[21,25]],17:[[0,2],21,23,81],18:[[0,3],21,23,[25,27],81,82],19:[0],20:[0],51:[[0,3],21,22],52:[[0,3],21,22,24,81],53:[[0,2],[21,23],81]},45:{0:[0],1:[[0,9],[21,27]],2:[[0,5],[21,26]],3:[[0,5],11,12,[21,32]],4:[0,1,[3,6],11,[21,23],81],5:[[0,3],12,21],6:[[0,3],21,81],7:[[0,3],21,22],8:[[0,4],21,81],9:[[0,3],[21,24],81],10:[[0,2],[21,31]],11:[[0,2],[21,23]],12:[[0,2],[21,29],81],13:[[0,2],[21,24],81],14:[[0,2],[21,25],81]},46:{0:[0],1:[0,1,[5,8]],2:[0,1],3:[0,[21,23]],90:[[0,3],[5,7],[21,39]]},50:{0:[0],1:[[0,19]],2:[0,[22,38],[40,43]],3:[0,[81,84]]},51:{0:[0],1:[0,1,[4,8],[12,15],[21,24],29,31,32,[81,84]],3:[[0,4],11,21,22],4:[[0,3],11,21,22],5:[[0,4],21,22,24,25],6:[0,1,3,23,26,[81,83]],7:[0,1,3,4,[22,27],81],8:[[0,2],11,12,[21,24]],9:[[0,4],[21,23]],10:[[0,2],11,24,25,28],11:[[0,2],[11,13],23,24,26,29,32,33,81],13:[[0,4],[21,25],81],14:[[0,2],[21,25]],15:[[0,3],[21,29]],16:[[0,3],[21,23],81],17:[[0,3],[21,25],81],18:[[0,3],[21,27]],19:[[0,3],[21,23]],20:[[0,2],21,22,81],32:[0,[21,33]],33:[0,[21,38]],34:[0,1,[22,37]]},52:{0:[0],1:[[0,3],[11,15],[21,23],81],2:[0,1,3,21,22],3:[[0,3],[21,30],81,82],4:[[0,2],[21,25]],5:[[0,2],[21,27]],6:[[0,3],[21,28]],22:[0,1,[22,30]],23:[0,1,[22,28]],24:[0,1,[22,28]],26:[0,1,[22,36]],27:[[0,2],22,23,[25,32]]},53:{0:[0],1:[[0,3],[11,14],21,22,[24,29],81],3:[[0,2],[21,26],28,81],4:[[0,2],[21,28]],5:[[0,2],[21,24]],6:[[0,2],[21,30]],7:[[0,2],[21,24]],8:[[0,2],[21,29]],9:[[0,2],[21,27]],23:[0,1,[22,29],31],25:[[0,4],[22,32]],26:[0,1,[21,28]],27:[0,1,[22,30]],28:[0,1,22,23],29:[0,1,[22,32]],31:[0,2,3,[22,24]],34:[0,[21,23]],33:[0,21,[23,25]],35:[0,[21,28]]},54:{0:[0],1:[[0,2],[21,27]],21:[0,[21,29],32,33],22:[0,[21,29],[31,33]],23:[0,1,[22,38]],24:[0,[21,31]],25:[0,[21,27]],26:[0,[21,27]]},61:{0:[0],1:[[0,4],[11,16],22,[24,26]],2:[[0,4],22],3:[[0,4],[21,24],[26,31]],4:[[0,4],[22,31],81],5:[[0,2],[21,28],81,82],6:[[0,2],[21,32]],7:[[0,2],[21,30]],8:[[0,2],[21,31]],9:[[0,2],[21,29]],10:[[0,2],[21,26]]},62:{0:[0],1:[[0,5],11,[21,23]],2:[0,1],3:[[0,2],21],4:[[0,3],[21,23]],5:[[0,3],[21,25]],6:[[0,2],[21,23]],7:[[0,2],[21,25]],8:[[0,2],[21,26]],9:[[0,2],[21,24],81,82],10:[[0,2],[21,27]],11:[[0,2],[21,26]],12:[[0,2],[21,28]],24:[0,21,[24,29]],26:[0,21,[23,30]],29:[0,1,[21,27]],30:[0,1,[21,27]]},63:{0:[0],1:[[0,5],[21,23]],2:[0,2,[21,25]],21:[0,[21,23],[26,28]],22:[0,[21,24]],23:[0,[21,24]],25:[0,[21,25]],26:[0,[21,26]],27:[0,1,[21,26]],28:[[0,2],[21,23]]},64:{0:[0],1:[0,1,[4,6],21,22,81],2:[[0,3],5,[21,23]],3:[[0,3],[21,24],81],4:[[0,2],[21,25]],5:[[0,2],21,22]},65:{0:[0],1:[[0,9],21],2:[[0,5]],21:[0,1,22,23],22:[0,1,22,23],23:[[0,3],[23,25],27,28],28:[0,1,[22,29]],29:[0,1,[22,29]],30:[0,1,[22,24]],31:[0,1,[21,31]],32:[0,1,[21,27]],40:[0,2,3,[21,28]],42:[[0,2],21,[23,26]],43:[0,1,[21,26]],90:[[0,4]],27:[[0,2],22,23]},71:{0:[0]},81:{0:[0]},82:{0:[0]}},i=parseInt(e.substr(0,2),10),r=parseInt(e.substr(2,2),10),n=parseInt(e.substr(4,2),10);if(!a[i]||!a[i][r])return!1;for(var s=!1,o=a[i][r],l=0;l<o.length;l++)if(t.isArray(o[l])&&o[l][0]<=n&&n<=o[l][1]||!t.isArray(o[l])&&n===o[l]){s=!0;break}if(!s)return!1;var d;d=18===e.length?e.substr(6,8):"19"+e.substr(6,6);var u=parseInt(d.substr(0,4),10),f=parseInt(d.substr(4,2),10),c=parseInt(d.substr(6,2),10);if(!FormValidation.Helper.date(u,f,c))return!1;if(18===e.length){var h=0,p=[7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2];for(l=0;17>l;l++)h+=parseInt(e.charAt(l),10)*p[l];return h=(12-h%11)%11,("X"!==e.charAt(17).toUpperCase()?parseInt(e.charAt(17),10):10)===h}return!0},_cz:function(t){if(!/^\d{9,10}$/.test(t))return!1;var e=1900+parseInt(t.substr(0,2),10),a=parseInt(t.substr(2,2),10)%50%20,i=parseInt(t.substr(4,2),10);if(9===t.length){if(e>=1980&&(e-=100),e>1953)return!1}else 1954>e&&(e+=100);if(!FormValidation.Helper.date(e,a,i))return!1;if(10===t.length){var r=parseInt(t.substr(0,9),10)%11;return 1985>e&&(r%=10),r+""===t.substr(9,1)}return!0},_dk:function(t){if(!/^[0-9]{6}[-]{0,1}[0-9]{4}$/.test(t))return!1;t=t.replace(/-/g,"");var e=parseInt(t.substr(0,2),10),a=parseInt(t.substr(2,2),10),i=parseInt(t.substr(4,2),10);switch(!0){case-1!=="5678".indexOf(t.charAt(6))&&i>=58:i+=1800;break;case-1!=="0123".indexOf(t.charAt(6)):case-1!=="49".indexOf(t.charAt(6))&&i>=37:i+=1900;break;default:i+=2e3}return FormValidation.Helper.date(i,a,e)},_ee:function(t){return this._lt(t)},_es:function(t){var e=/^[0-9]{8}[-]{0,1}[A-HJ-NP-TV-Z]$/.test(t),a=/^[XYZ][-]{0,1}[0-9]{7}[-]{0,1}[A-HJ-NP-TV-Z]$/.test(t),i=/^[A-HNPQS][-]{0,1}[0-9]{7}[-]{0,1}[0-9A-J]$/.test(t);if(!e&&!a&&!i)return!1;t=t.replace(/-/g,"");var r,n,s=!0;if(e||a){n="DNI";var o="XYZ".indexOf(t.charAt(0));return-1!==o&&(t=o+t.substr(1)+"",n="NIE"),r=parseInt(t.substr(0,8),10),r="TRWAGMYFPDXBNJZSQVHLCKE"[r%23],{valid:r===t.substr(8,1),type:n}}r=t.substr(1,7),n="CIF";for(var l=t[0],d=t.substr(-1),u=0,f=0;f<r.length;f++)if(f%2!=0)u+=parseInt(r[f],10);else{var c=""+2*parseInt(r[f],10);u+=parseInt(c[0],10),2===c.length&&(u+=parseInt(c[1],10))}var h=u-10*Math.floor(u/10);return 0!==h&&(h=10-h),s=-1!=="KQS".indexOf(l)?d==="JABCDEFGHI"[h]:-1!=="ABEH".indexOf(l)?d===""+h:d===""+h||d==="JABCDEFGHI"[h],{valid:s,type:n}},_fi:function(t){if(!/^[0-9]{6}[-+A][0-9]{3}[0-9ABCDEFHJKLMNPRSTUVWXY]$/.test(t))return!1;var e=parseInt(t.substr(0,2),10),a=parseInt(t.substr(2,2),10),i=parseInt(t.substr(4,2),10);if(i={"+":1800,"-":1900,A:2e3}[t.charAt(6)]+i,!FormValidation.Helper.date(i,a,e))return!1;if(2>parseInt(t.substr(7,3),10))return!1;var r=t.substr(0,6)+t.substr(7,3)+"";return r=parseInt(r,10),"0123456789ABCDEFHJKLMNPRSTUVWXY".charAt(r%31)===t.charAt(10)},_hr:function(t){return!!/^[0-9]{11}$/.test(t)&&FormValidation.Helper.mod11And10(t)},_ie:function(t){if(!/^\d{7}[A-W][AHWTX]?$/.test(t))return!1;var e=function(t){for(;t.length<7;)t="0"+t;for(var e="WABCDEFGHIJKLMNOPQRSTUV",a=0,i=0;7>i;i++)a+=parseInt(t.charAt(i),10)*(8-i);return a+=9*e.indexOf(t.substr(7)),e[a%23]};return 9!==t.length||"A"!==t.charAt(8)&&"H"!==t.charAt(8)?t.charAt(7)===e(t.substr(0,7)):t.charAt(7)===e(t.substr(0,7)+t.substr(8)+"")},_is:function(t){if(!/^[0-9]{6}[-]{0,1}[0-9]{4}$/.test(t))return!1;t=t.replace(/-/g,"");var e=parseInt(t.substr(0,2),10),a=parseInt(t.substr(2,2),10),i=parseInt(t.substr(4,2),10),r=parseInt(t.charAt(9),10);if(i=9===r?1900+i:100*(20+r)+i,!FormValidation.Helper.date(i,a,e,!0))return!1;for(var n=0,s=[3,2,7,6,5,4,3,2],o=0;8>o;o++)n+=parseInt(t.charAt(o),10)*s[o];return(n=11-n%11)+""===t.charAt(8)},_lt:function(t){if(!/^[0-9]{11}$/.test(t))return!1;var e=parseInt(t.charAt(0),10),a=parseInt(t.substr(1,2),10),i=parseInt(t.substr(3,2),10),r=parseInt(t.substr(5,2),10);if(a=100*(e%2==0?17+e/2:17+(e+1)/2)+a,!FormValidation.Helper.date(a,i,r,!0))return!1;for(var n=0,s=[1,2,3,4,5,6,7,8,9,1],o=0;10>o;o++)n+=parseInt(t.charAt(o),10)*s[o];if(10!==(n%=11))return n+""===t.charAt(10);for(n=0,s=[3,4,5,6,7,8,9,1,2,3],o=0;10>o;o++)n+=parseInt(t.charAt(o),10)*s[o];return 10===(n%=11)&&(n=0),n+""===t.charAt(10)},_lv:function(t){if(!/^[0-9]{6}[-]{0,1}[0-9]{5}$/.test(t))return!1;t=t.replace(/\D/g,"");var e=parseInt(t.substr(0,2),10),a=parseInt(t.substr(2,2),10),i=parseInt(t.substr(4,2),10);if(i=i+1800+100*parseInt(t.charAt(6),10),!FormValidation.Helper.date(i,a,e,!0))return!1;for(var r=0,n=[10,5,8,4,2,1,6,3,7,9],s=0;10>s;s++)r+=parseInt(t.charAt(s),10)*n[s];return(r=(r+1)%11%10)+""===t.charAt(10)},_nl:function(t){if(t.length<8)return!1;if(8===t.length&&(t="0"+t),!/^[0-9]{4}[.]{0,1}[0-9]{2}[.]{0,1}[0-9]{3}$/.test(t))return!1;if(t=t.replace(/\./g,""),0===parseInt(t,10))return!1;for(var e=0,a=t.length,i=0;a-1>i;i++)e+=(9-i)*parseInt(t.charAt(i),10);return 10===(e%=11)&&(e=0),e+""===t.charAt(a-1)},_pl:function(t){if(!/^[0-9]{11}$/.test(t))return!1;for(var e=0,a=t.length,i=[1,3,7,9,1,3,7,9,1,3,7],r=0;a-1>r;r++)e+=i[r]*parseInt(t.charAt(r),10);return 0===(e%=10)&&(e=10),(e=10-e)+""===t.charAt(a-1)},_ro:function(t){if(!/^[0-9]{13}$/.test(t))return!1;var e=parseInt(t.charAt(0),10);if(0===e||7===e||8===e)return!1;var a=parseInt(t.substr(1,2),10),i=parseInt(t.substr(3,2),10),r=parseInt(t.substr(5,2),10),n={1:1900,2:1900,3:1800,4:1800,5:2e3,6:2e3};if(r>31&&i>12)return!1;if(9!==e&&(a=n[e+""]+a,!FormValidation.Helper.date(a,i,r)))return!1;for(var s=0,o=[2,7,9,1,4,6,3,5,8,2,7,9],l=t.length,d=0;l-1>d;d++)s+=parseInt(t.charAt(d),10)*o[d];return 10===(s%=11)&&(s=1),s+""===t.charAt(l-1)},_se:function(t){if(!/^[0-9]{10}$/.test(t)&&!/^[0-9]{6}[-|+][0-9]{4}$/.test(t))return!1;t=t.replace(/[^0-9]/g,"");var e=parseInt(t.substr(0,2),10)+1900,a=parseInt(t.substr(2,2),10),i=parseInt(t.substr(4,2),10);return!!FormValidation.Helper.date(e,a,i)&&FormValidation.Helper.luhn(t)},_sk:function(t){return this._cz(t)},_sm:function(t){return/^\d{5}$/.test(t)},_th:function(t){if(13!==t.length)return!1;for(var e=0,a=0;12>a;a++)e+=parseInt(t.charAt(a),10)*(13-a);return(11-e%11)%10===parseInt(t.charAt(12),10)},_tr:function(t){if(11!==t.length)return!1;for(var e=0,a=0;10>a;a++)e+=parseInt(t.charAt(a),10);return e%10===parseInt(t.charAt(10),10)},_za:function(t){if(!/^[0-9]{10}[0|1][8|9][0-9]$/.test(t))return!1;var e=parseInt(t.substr(0,2),10),a=(new Date).getFullYear()%100,i=parseInt(t.substr(2,2),10),r=parseInt(t.substr(4,2),10);return e=e>=a?e+1900:e+2e3,!!FormValidation.Helper.date(e,i,r)&&FormValidation.Helper.luhn(t)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{identical:{default:"Please enter the same value"}}}),FormValidation.Validator.identical={html5Attributes:{message:"message",field:"field"},init:function(t,e,a,i){var r=t.getFieldElements(a.field);t.onLiveChange(r,"live_"+i,function(){t.getStatus(e,i)!==t.STATUS_NOT_VALIDATED&&t.revalidateField(e)})},destroy:function(t,e,a,i){var r=t.getFieldElements(a.field);t.offLiveChange(r,"live_"+i)},validate:function(t,e,a,i){var r=t.getFieldValue(e,i),n=t.getFieldElements(a.field);return null===n||0===n.length||!n.val()||!e.val()||r===t.getFieldValue(n,i)&&(t.updateStatus(n,t.STATUS_VALID,i),!0)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{imei:{default:"Please enter a valid IMEI number"}}}),FormValidation.Validator.imei={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;switch(!0){case/^\d{15}$/.test(r):case/^\d{2}-\d{6}-\d{6}-\d{1}$/.test(r):case/^\d{2}\s\d{6}\s\d{6}\s\d{1}$/.test(r):return r=r.replace(/[^0-9]/g,""),FormValidation.Helper.luhn(r);case/^\d{14}$/.test(r):case/^\d{16}$/.test(r):case/^\d{2}-\d{6}-\d{6}(|-\d{2})$/.test(r):case/^\d{2}\s\d{6}\s\d{6}(|\s\d{2})$/.test(r):return!0;default:return!1}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{imo:{default:"Please enter a valid IMO number"}}}),FormValidation.Validator.imo={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;if(!/^IMO \d{7}$/i.test(r))return!1;for(var n=0,s=r.replace(/^.*(\d{7})$/,"$1"),o=6;o>=1;o--)n+=s.slice(6-o,-o)*(o+1);return n%10===parseInt(s.charAt(6),10)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{integer:{default:"Please enter a valid number"}}}),FormValidation.Validator.integer={html5Attributes:{message:"message",thousandsseparator:"thousandsSeparator",decimalseparator:"decimalSeparator"},enableByHtml5:function(t){return"number"===t.attr("type")&&(void 0===t.attr("step")||t.attr("step")%1==0)},validate:function(t,e,a,i){if(this.enableByHtml5(e)&&e.get(0).validity&&!0===e.get(0).validity.badInput)return!1;var r=t.getFieldValue(e,i);if(""===r)return!0;var n=a.decimalSeparator||".",s=a.thousandsSeparator||"";n="."===n?"\\.":n,s="."===s?"\\.":s;var o=new RegExp("^-?[0-9]{1,3}("+s+"[0-9]{3})*("+n+"[0-9]+)?$"),l=new RegExp(s,"g");return!!o.test(r)&&(s&&(r=r.replace(l,"")),n&&(r=r.replace(n,".")),!(isNaN(r)||!isFinite(r))&&(r=parseFloat(r),Math.floor(r)===r))}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{ip:{default:"Please enter a valid IP address",ipv4:"Please enter a valid IPv4 address",ipv6:"Please enter a valid IPv6 address"}}}),FormValidation.Validator.ip={html5Attributes:{message:"message",ipv4:"ipv4",ipv6:"ipv6"},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;i=t.extend({},{ipv4:!0,ipv6:!0},i);var s,o=e.getLocale(),l=/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\/([0-9]|[1-2][0-9]|3[0-2]))?$/,d=/^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*(\/(\d|\d\d|1[0-1]\d|12[0-8]))?$/,u=!1;switch(!0){case i.ipv4&&!i.ipv6:u=l.test(n),s=i.message||FormValidation.I18n[o].ip.ipv4;break;case!i.ipv4&&i.ipv6:u=d.test(n),s=i.message||FormValidation.I18n[o].ip.ipv6;break;case i.ipv4&&i.ipv6:default:u=l.test(n)||d.test(n),s=i.message||FormValidation.I18n[o].ip.default}return{valid:u,message:s}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{isbn:{default:"Please enter a valid ISBN number"}}}),FormValidation.Validator.isbn={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;var n;switch(!0){case/^\d{9}[\dX]$/.test(r):case 13===r.length&&/^(\d+)-(\d+)-(\d+)-([\dX])$/.test(r):case 13===r.length&&/^(\d+)\s(\d+)\s(\d+)\s([\dX])$/.test(r):n="ISBN10";break;case/^(978|979)\d{9}[\dX]$/.test(r):case 17===r.length&&/^(978|979)-(\d+)-(\d+)-(\d+)-([\dX])$/.test(r):case 17===r.length&&/^(978|979)\s(\d+)\s(\d+)\s(\d+)\s([\dX])$/.test(r):n="ISBN13";break;default:return!1}var s,o,l=(r=r.replace(/[^0-9X]/gi,"")).split(""),d=l.length,u=0;switch(n){case"ISBN10":for(u=0,s=0;d-1>s;s++)u+=parseInt(l[s],10)*(10-s);return o=11-u%11,11===o?o=0:10===o&&(o="X"),{type:n,valid:o+""===l[d-1]};case"ISBN13":for(u=0,s=0;d-1>s;s++)u+=s%2==0?parseInt(l[s],10):3*parseInt(l[s],10);return 10===(o=10-u%10)&&(o="0"),{type:n,valid:o+""===l[d-1]};default:return!1}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{isin:{default:"Please enter a valid ISIN number"}}}),FormValidation.Validator.isin={COUNTRY_CODES:"AF|AX|AL|DZ|AS|AD|AO|AI|AQ|AG|AR|AM|AW|AU|AT|AZ|BS|BH|BD|BB|BY|BE|BZ|BJ|BM|BT|BO|BQ|BA|BW|BV|BR|IO|BN|BG|BF|BI|KH|CM|CA|CV|KY|CF|TD|CL|CN|CX|CC|CO|KM|CG|CD|CK|CR|CI|HR|CU|CW|CY|CZ|DK|DJ|DM|DO|EC|EG|SV|GQ|ER|EE|ET|FK|FO|FJ|FI|FR|GF|PF|TF|GA|GM|GE|DE|GH|GI|GR|GL|GD|GP|GU|GT|GG|GN|GW|GY|HT|HM|VA|HN|HK|HU|IS|IN|ID|IR|IQ|IE|IM|IL|IT|JM|JP|JE|JO|KZ|KE|KI|KP|KR|KW|KG|LA|LV|LB|LS|LR|LY|LI|LT|LU|MO|MK|MG|MW|MY|MV|ML|MT|MH|MQ|MR|MU|YT|MX|FM|MD|MC|MN|ME|MS|MA|MZ|MM|NA|NR|NP|NL|NC|NZ|NI|NE|NG|NU|NF|MP|NO|OM|PK|PW|PS|PA|PG|PY|PE|PH|PN|PL|PT|PR|QA|RE|RO|RU|RW|BL|SH|KN|LC|MF|PM|VC|WS|SM|ST|SA|SN|RS|SC|SL|SG|SX|SK|SI|SB|SO|ZA|GS|SS|ES|LK|SD|SR|SJ|SZ|SE|CH|SY|TW|TJ|TZ|TH|TL|TG|TK|TO|TT|TN|TR|TM|TC|TV|UG|UA|AE|GB|US|UM|UY|UZ|VU|VE|VN|VG|VI|WF|EH|YE|ZM|ZW",validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;if(r=r.toUpperCase(),!new RegExp("^("+this.COUNTRY_CODES+")[0-9A-Z]{10}$").test(r))return!1;for(var n="",s=r.length,o=0;s-1>o;o++){var l=r.charCodeAt(o);n+=l>57?(l-55).toString():r.charAt(o)}var d="",u=n.length,f=u%2!=0?0:1;for(o=0;u>o;o++)d+=parseInt(n[o],10)*(o%2===f?2:1)+"";var c=0;for(o=0;o<d.length;o++)c+=parseInt(d.charAt(o),10);return(c=(10-c%10)%10)+""===r.charAt(s-1)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{ismn:{default:"Please enter a valid ISMN number"}}}),FormValidation.Validator.ismn={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;var n;switch(!0){case/^M\d{9}$/.test(r):case/^M-\d{4}-\d{4}-\d{1}$/.test(r):case/^M\s\d{4}\s\d{4}\s\d{1}$/.test(r):n="ISMN10";break;case/^9790\d{9}$/.test(r):case/^979-0-\d{4}-\d{4}-\d{1}$/.test(r):case/^979\s0\s\d{4}\s\d{4}\s\d{1}$/.test(r):n="ISMN13";break;default:return!1}"ISMN10"===n&&(r="9790"+r.substr(1));for(var s=(r=r.replace(/[^0-9]/gi,"")).length,o=0,l=[1,3],d=0;s-1>d;d++)o+=parseInt(r.charAt(d),10)*l[d%2];return o=10-o%10,{type:n,valid:o+""===r.charAt(s-1)}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{issn:{default:"Please enter a valid ISSN number"}}}),FormValidation.Validator.issn={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;if(!/^\d{4}\-\d{3}[\dX]$/.test(r))return!1;var n=(r=r.replace(/[^0-9X]/gi,"")).split(""),s=n.length,o=0;"X"===n[7]&&(n[7]=10);for(var l=0;s>l;l++)o+=parseInt(n[l],10)*(8-l);return o%11==0}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{lessThan:{default:"Please enter a value less than or equal to %s",notInclusive:"Please enter a value less than %s"}}}),FormValidation.Validator.lessThan={html5Attributes:{message:"message",value:"value",inclusive:"inclusive"},enableByHtml5:function(t){var e=t.attr("type"),a=t.attr("max");return!(!a||"date"===e)&&{value:a}},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;n=this._format(n);var s=e.getLocale(),o=t.isNumeric(i.value)?i.value:e.getDynamicOption(a,i.value),l=this._format(o);return!0===i.inclusive||void 0===i.inclusive?{valid:t.isNumeric(n)&&parseFloat(n)<=l,message:FormValidation.Helper.format(i.message||FormValidation.I18n[s].lessThan.default,o)}:{valid:t.isNumeric(n)&&parseFloat(n)<l,message:FormValidation.Helper.format(i.message||FormValidation.I18n[s].lessThan.notInclusive,o)}},_format:function(t){return(t+"").replace(",",".")}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{mac:{default:"Please enter a valid MAC address"}}}),FormValidation.Validator.mac={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);return""===r||(/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/.test(r)||/^([0-9A-Fa-f]{4}\.){2}([0-9A-Fa-f]{4})$/.test(r))}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{meid:{default:"Please enter a valid MEID number"}}}),FormValidation.Validator.meid={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;switch(!0){case/^[0-9A-F]{15}$/i.test(r):case/^[0-9A-F]{2}[-][0-9A-F]{6}[-][0-9A-F]{6}[-][0-9A-F]$/i.test(r):case/^\d{19}$/.test(r):case/^\d{5}[-]\d{5}[-]\d{4}[-]\d{4}[-]\d$/.test(r):var n=r.charAt(r.length-1);if((r=r.replace(/[- ]/g,"")).match(/^\d*$/i))return FormValidation.Helper.luhn(r);r=r.slice(0,-1);for(var s="",o=1;13>=o;o+=2)s+=(2*parseInt(r.charAt(o),16)).toString(16);var l=0;for(o=0;o<s.length;o++)l+=parseInt(s.charAt(o),16);return l%10==0?"0"===n:n===(2*(10*Math.floor((l+10)/10)-l)).toString(16);case/^[0-9A-F]{14}$/i.test(r):case/^[0-9A-F]{2}[-][0-9A-F]{6}[-][0-9A-F]{6}$/i.test(r):case/^\d{18}$/.test(r):case/^\d{5}[-]\d{5}[-]\d{4}[-]\d{4}$/.test(r):return!0;default:return!1}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{notEmpty:{default:"Please enter a value"}}}),FormValidation.Validator.notEmpty={enableByHtml5:function(t){var e=t.attr("required")+"";return"required"===e||"true"===e},validate:function(e,a,i,r){var n=a.attr("type");if("radio"===n||"checkbox"===n){var s=e.getNamespace();return e.getFieldElements(a.attr("data-"+s+"-field")).filter(":checked").length>0}if("number"===n&&a.get(0).validity&&!0===a.get(0).validity.badInput)return!0;var o=e.getFieldValue(a,r);return""!==t.trim(o)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{numeric:{default:"Please enter a valid float number"}}}),FormValidation.Validator.numeric={html5Attributes:{message:"message",separator:"separator",thousandsseparator:"thousandsSeparator",decimalseparator:"decimalSeparator"},enableByHtml5:function(t){return"number"===t.attr("type")&&void 0!==t.attr("step")&&t.attr("step")%1!=0},validate:function(t,e,a,i){if(this.enableByHtml5(e)&&e.get(0).validity&&!0===e.get(0).validity.badInput)return!1;var r=t.getFieldValue(e,i);if(""===r)return!0;var n=a.separator||a.decimalSeparator||".",s=a.thousandsSeparator||"";r.substr(0,1)===n?r="0"+n+r.substr(1):r.substr(0,2)==="-"+n&&(r="-0"+n+r.substr(2)),n="."===n?"\\.":n,s="."===s?"\\.":s;var o=new RegExp("^-?[0-9]{1,3}("+s+"[0-9]{3})*("+n+"[0-9]+)?$"),l=new RegExp(s,"g");return!!o.test(r)&&(s&&(r=r.replace(l,"")),n&&(r=r.replace(n,".")),!isNaN(parseFloat(r))&&isFinite(r))}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{phone:{default:"Please enter a valid phone number",country:"Please enter a valid phone number in %s",countries:{AE:"United Arab Emirates",BG:"Bulgaria",BR:"Brazil",CN:"China",CZ:"Czech Republic",DE:"Germany",DK:"Denmark",ES:"Spain",FR:"France",GB:"United Kingdom",IN:"India",MA:"Morocco",NL:"Netherlands",PK:"Pakistan",RO:"Romania",RU:"Russia",SK:"Slovakia",TH:"Thailand",US:"USA",VE:"Venezuela"}}}}),FormValidation.Validator.phone={html5Attributes:{message:"message",country:"country"},COUNTRY_CODES:["AE","BG","BR","CN","CZ","DE","DK","ES","FR","GB","IN","MA","NL","PK","RO","RU","SK","TH","US","VE"],validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;var s=e.getLocale(),o=i.country;if(("string"!=typeof o||-1===t.inArray(o,this.COUNTRY_CODES))&&(o=e.getDynamicOption(a,o)),!o||-1===t.inArray(o.toUpperCase(),this.COUNTRY_CODES))return!0;var l=!0;switch(o.toUpperCase()){case"AE":n=t.trim(n),l=/^(((\+|00)?971[\s\.-]?(\(0\)[\s\.-]?)?|0)(\(5(0|2|5|6)\)|5(0|2|5|6)|2|3|4|6|7|9)|60)([\s\.-]?[0-9]){7}$/.test(n);break;case"BG":n=n.replace(/\+|\s|-|\/|\(|\)/gi,""),l=/^(0|359|00)(((700|900)[0-9]{5}|((800)[0-9]{5}|(800)[0-9]{4}))|(87|88|89)([0-9]{7})|((2[0-9]{7})|(([3-9][0-9])(([0-9]{6})|([0-9]{5})))))$/.test(n);break;case"BR":n=t.trim(n),l=/^(([\d]{4}[-.\s]{1}[\d]{2,3}[-.\s]{1}[\d]{2}[-.\s]{1}[\d]{2})|([\d]{4}[-.\s]{1}[\d]{3}[-.\s]{1}[\d]{4})|((\(?\+?[0-9]{2}\)?\s?)?(\(?\d{2}\)?\s?)?\d{4,5}[-.\s]?\d{4}))$/.test(n);break;case"CN":n=t.trim(n),l=/^((00|\+)?(86(?:-| )))?((\d{11})|(\d{3}[- ]{1}\d{4}[- ]{1}\d{4})|((\d{2,4}[- ]){1}(\d{7,8}|(\d{3,4}[- ]{1}\d{4}))([- ]{1}\d{1,4})?))$/.test(n);break;case"CZ":l=/^(((00)([- ]?)|\+)(420)([- ]?))?((\d{3})([- ]?)){2}(\d{3})$/.test(n);break;case"DE":n=t.trim(n),l=/^(((((((00|\+)49[ \-\/]?)|0)[1-9][0-9]{1,4})[\-\/]?)|((((00|\+)49\()|\(0)[1-9][0-9]{1,4}\)[\-\/]?))[0-9]{1,7}([\-\/]?[0-9]{1,5})?)$/.test(n);break;case"DK":n=t.trim(n),l=/^(\+45|0045|\(45\))?\s?[2-9](\s?\d){7}$/.test(n);break;case"ES":n=t.trim(n),l=/^(?:(?:(?:\+|00)34\D?))?(?:5|6|7|8|9)(?:\d\D?){8}$/.test(n);break;case"FR":n=t.trim(n),l=/^(?:(?:(?:\+|00)33[ ]?(?:\(0\)[ ]?)?)|0){1}[1-9]{1}([ .-]?)(?:\d{2}\1?){3}\d{2}$/.test(n);break;case"GB":n=t.trim(n),l=/^\(?(?:(?:0(?:0|11)\)?[\s-]?\(?|\+)44\)?[\s-]?\(?(?:0\)?[\s-]?\(?)?|0)(?:\d{2}\)?[\s-]?\d{4}[\s-]?\d{4}|\d{3}\)?[\s-]?\d{3}[\s-]?\d{3,4}|\d{4}\)?[\s-]?(?:\d{5}|\d{3}[\s-]?\d{3})|\d{5}\)?[\s-]?\d{4,5}|8(?:00[\s-]?11[\s-]?11|45[\s-]?46[\s-]?4\d))(?:(?:[\s-]?(?:x|ext\.?\s?|\#)\d+)?)$/.test(n);break;case"IN":n=t.trim(n),l=/((\+?)((0[ -]+)*|(91 )*)(\d{12}|\d{10}))|\d{5}([- ]*)\d{6}/.test(n);break;case"MA":n=t.trim(n),l=/^(?:(?:(?:\+|00)212[\s]?(?:[\s]?\(0\)[\s]?)?)|0){1}(?:5[\s.-]?[2-3]|6[\s.-]?[13-9]){1}[0-9]{1}(?:[\s.-]?\d{2}){3}$/.test(n);break;case"NL":n=t.trim(n),l=/^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/gm.test(n);break;case"PK":n=t.trim(n),l=/^0?3[0-9]{2}[0-9]{7}$/.test(n);break;case"RO":l=/^(\+4|)?(07[0-8]{1}[0-9]{1}|02[0-9]{2}|03[0-9]{2}){1}?(\s|\.|\-)?([0-9]{3}(\s|\.|\-|)){2}$/g.test(n);break;case"RU":l=/^((8|\+7|007)[\-\.\/ ]?)?([\(\/\.]?\d{3}[\)\/\.]?[\-\.\/ ]?)?[\d\-\.\/ ]{7,10}$/g.test(n);break;case"SK":l=/^(((00)([- ]?)|\+)(421)([- ]?))?((\d{3})([- ]?)){2}(\d{3})$/.test(n);break;case"TH":l=/^0\(?([6|8-9]{2})*-([0-9]{3})*-([0-9]{4})$/.test(n);break;case"VE":n=t.trim(n),l=/^0(?:2(?:12|4[0-9]|5[1-9]|6[0-9]|7[0-8]|8[1-35-8]|9[1-5]|3[45789])|4(?:1[246]|2[46]))\d{7}$/.test(n);break;case"US":default:l=/^(?:(1\-?)|(\+1 ?))?\(?\d{3}\)?[\-\.\s]?\d{3}[\-\.\s]?\d{4}$/.test(n)}return{valid:l,message:FormValidation.Helper.format(i.message||FormValidation.I18n[s].phone.country,FormValidation.I18n[s].phone.countries[o])}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{promise:{default:"Please enter a valid value"}}}),FormValidation.Validator.promise={priority:999,html5Attributes:{message:"message",promise:"promise"},validate:function(e,a,i,r){var n=e.getFieldValue(a,r),s=new t.Deferred;return FormValidation.Helper.call(i.promise,[n,e,a]).done(function(t){s.resolve(a,r,t)}).fail(function(t){(t=t||{}).valid=!1,s.resolve(a,r,t)}),s}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{regexp:{default:"Please enter a value matching the pattern"}}}),FormValidation.Validator.regexp={html5Attributes:{message:"message",flags:"flags",regexp:"regexp"},enableByHtml5:function(t){var e=t.attr("pattern");return!!e&&{regexp:e}},validate:function(t,e,a,i){var r=t.getFieldValue(e,i);return""===r||("string"==typeof a.regexp?a.flags?new RegExp(a.regexp,a.flags):new RegExp(a.regexp):a.regexp).test(r)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{remote:{default:"Please enter a valid value"}}}),FormValidation.Validator.remote={priority:1e3,html5Attributes:{async:"async",crossdomain:"crossDomain",data:"data",datatype:"dataType",delay:"delay",message:"message",name:"name",type:"type",url:"url",validkey:"validKey"},destroy:function(t,e,a,i){var r=t.getNamespace(),n=e.data(r+"."+i+".timer");n&&(clearTimeout(n),e.removeData(r+"."+i+".timer"))},validate:function(e,a,i,r){function n(){var e=t.ajax(h);return e.success(function(t){t.valid=!0===t[c]||"true"===t[c]||!1!==t[c]&&"false"!==t[c]&&null,l.resolve(a,r,t)}).error(function(t){l.resolve(a,r,{valid:!1})}),l.fail(function(){e.abort()}),l}var s=e.getNamespace(),o=e.getFieldValue(a,r),l=new t.Deferred;if(""===o)return l.resolve(a,r,{valid:!0}),l;var d=a.attr("data-"+s+"-field"),u=i.data||{},f=i.url,c=i.validKey||"valid";"function"==typeof u&&(u=u.call(this,e,a,o)),"string"==typeof u&&(u=JSON.parse(u)),"function"==typeof f&&(f=f.call(this,e,a,o)),u[i.name||d]=o;var h={async:null===i.async||!0===i.async||"true"===i.async,data:u,dataType:i.dataType||"json",headers:i.headers||{},type:i.type||"GET",url:f};return null!==i.crossDomain&&(h.crossDomain=!0===i.crossDomain||"true"===i.crossDomain),i.delay?(a.data(s+"."+r+".timer")&&clearTimeout(a.data(s+"."+r+".timer")),a.data(s+"."+r+".timer",setTimeout(n,i.delay)),l):n()}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{rtn:{default:"Please enter a valid RTN number"}}}),FormValidation.Validator.rtn={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;if(!/^\d{9}$/.test(r))return!1;for(var n=0,s=0;s<r.length;s+=3)n+=3*parseInt(r.charAt(s),10)+7*parseInt(r.charAt(s+1),10)+parseInt(r.charAt(s+2),10);return 0!==n&&n%10==0}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{sedol:{default:"Please enter a valid SEDOL number"}}}),FormValidation.Validator.sedol={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;if(r=r.toUpperCase(),!/^[0-9A-Z]{7}$/.test(r))return!1;for(var n=0,s=[1,3,1,7,3,9,1],o=r.length,l=0;o-1>l;l++)n+=s[l]*parseInt(r.charAt(l),36);return(n=(10-n%10)%10)+""===r.charAt(o-1)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{siren:{default:"Please enter a valid SIREN number"}}}),FormValidation.Validator.siren={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);return""===r||!!/^\d{9}$/.test(r)&&FormValidation.Helper.luhn(r)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{siret:{default:"Please enter a valid SIRET number"}}}),FormValidation.Validator.siret={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;for(var n,s=0,o=r.length,l=0;o>l;l++)n=parseInt(r.charAt(l),10),l%2==0&&(n*=2)>9&&(n-=9),s+=n;return s%10==0}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{step:{default:"Please enter a valid step of %s"}}}),FormValidation.Validator.step={html5Attributes:{message:"message",base:"baseValue",step:"step"},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;if(i=t.extend({},{baseValue:0,step:1},i),n=parseFloat(n),!t.isNumeric(n))return!1;var s=function(t,e){var a=Math.pow(10,e),i=(t*=a)>0|-(0>t);return t%1==.5*i?(Math.floor(t)+(i>0))/a:Math.round(t)/a},o=e.getLocale(),l=function(t,e){if(0===e)return 1;var a=(t+"").split("."),i=(e+"").split("."),r=(1===a.length?0:a[1].length)+(1===i.length?0:i[1].length);return s(t-e*Math.floor(t/e),r)}(n-i.baseValue,i.step);return{valid:0===l||l===i.step,message:FormValidation.Helper.format(i.message||FormValidation.I18n[o].step.default,[i.step])}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{stringCase:{default:"Please enter only lowercase characters",upper:"Please enter only uppercase characters"}}}),FormValidation.Validator.stringCase={html5Attributes:{message:"message",case:"case"},validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;var n=t.getLocale(),s=(a.case||"lower").toLowerCase();return{valid:"upper"===s?r===r.toUpperCase():r===r.toLowerCase(),message:a.message||("upper"===s?FormValidation.I18n[n].stringCase.upper:FormValidation.I18n[n].stringCase.default)}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{stringLength:{default:"Please enter a value with valid length",less:"Please enter less than %s characters",more:"Please enter more than %s characters",between:"Please enter value between %s and %s characters long"}}}),FormValidation.Validator.stringLength={html5Attributes:{message:"message",min:"min",max:"max",trim:"trim",utf8bytes:"utf8Bytes"},enableByHtml5:function(e){var a={},i=e.attr("maxlength"),r=e.attr("minlength");return i&&(a.max=parseInt(i,10)),r&&(a.min=parseInt(r,10)),!t.isEmptyObject(a)&&a},validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if((!0===i.trim||"true"===i.trim)&&(n=t.trim(n)),""===n)return!0;var s=e.getLocale(),o=t.isNumeric(i.min)?i.min:e.getDynamicOption(a,i.min),l=t.isNumeric(i.max)?i.max:e.getDynamicOption(a,i.max),d=i.utf8Bytes?function(t){for(var e=t.length,a=t.length-1;a>=0;a--){var i=t.charCodeAt(a);i>127&&2047>=i?e++:i>2047&&65535>=i&&(e+=2),i>=56320&&57343>=i&&a--}return e}(n):n.length,u=!0,f=i.message||FormValidation.I18n[s].stringLength.default;switch((o&&d<parseInt(o,10)||l&&d>parseInt(l,10))&&(u=!1),!0){case!!o&&!!l:f=FormValidation.Helper.format(i.message||FormValidation.I18n[s].stringLength.between,[parseInt(o,10),parseInt(l,10)]);break;case!!o:f=FormValidation.Helper.format(i.message||FormValidation.I18n[s].stringLength.more,parseInt(o,10)-1);break;case!!l:f=FormValidation.Helper.format(i.message||FormValidation.I18n[s].stringLength.less,parseInt(l,10)+1)}return{valid:u,message:f}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{uri:{default:"Please enter a valid URI"}}}),FormValidation.Validator.uri={html5Attributes:{message:"message",allowlocal:"allowLocal",allowemptyprotocol:"allowEmptyProtocol",protocol:"protocol"},enableByHtml5:function(t){return"url"===t.attr("type")},validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;var n=!0===a.allowLocal||"true"===a.allowLocal,s=!0===a.allowEmptyProtocol||"true"===a.allowEmptyProtocol,o=(a.protocol||"http, https, ftp").split(",").join("|").replace(/\s/g,"");return new RegExp("^(?:(?:"+o+")://)"+(s?"?":"")+"(?:\\S+(?::\\S*)?@)?(?:"+(n?"":"(?!(?:10|127)(?:\\.\\d{1,3}){3})(?!(?:169\\.254|192\\.168)(?:\\.\\d{1,3}){2})(?!172\\.(?:1[6-9]|2\\d|3[0-1])(?:\\.\\d{1,3}){2})")+"(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[1-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]-?)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]-?)*[a-z\\u00a1-\\uffff0-9])*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,}))"+(n?"?":"")+")(?::\\d{2,5})?(?:/[^\\s]*)?$","i").test(r)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{uuid:{default:"Please enter a valid UUID number",version:"Please enter a valid UUID version %s number"}}}),FormValidation.Validator.uuid={html5Attributes:{message:"message",version:"version"},validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;var n=t.getLocale(),s={3:/^[0-9A-F]{8}-[0-9A-F]{4}-3[0-9A-F]{3}-[0-9A-F]{4}-[0-9A-F]{12}$/i,4:/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i,5:/^[0-9A-F]{8}-[0-9A-F]{4}-5[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i,all:/^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i},o=a.version?a.version+"":"all";return{valid:null===s[o]||s[o].test(r),message:a.version?FormValidation.Helper.format(a.message||FormValidation.I18n[n].uuid.version,a.version):a.message||FormValidation.I18n[n].uuid.default}}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{vat:{default:"Please enter a valid VAT number",country:"Please enter a valid VAT number in %s",countries:{AT:"Austria",BE:"Belgium",BG:"Bulgaria",BR:"Brazil",CH:"Switzerland",CY:"Cyprus",CZ:"Czech Republic",DE:"Germany",DK:"Denmark",EE:"Estonia",ES:"Spain",FI:"Finland",FR:"France",GB:"United Kingdom",GR:"Greek",EL:"Greek",HU:"Hungary",HR:"Croatia",IE:"Ireland",IS:"Iceland",IT:"Italy",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",MT:"Malta",NL:"Netherlands",NO:"Norway",PL:"Poland",PT:"Portugal",RO:"Romania",RU:"Russia",RS:"Serbia",SE:"Sweden",SI:"Slovenia",SK:"Slovakia",VE:"Venezuela",ZA:"South Africa"}}}}),FormValidation.Validator.vat={html5Attributes:{message:"message",country:"country"},COUNTRY_CODES:["AT","BE","BG","BR","CH","CY","CZ","DE","DK","EE","EL","ES","FI","FR","GB","GR","HR","HU","IE","IS","IT","LT","LU","LV","MT","NL","NO","PL","PT","RO","RU","RS","SE","SK","SI","VE","ZA"],validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n)return!0;var s=e.getLocale(),o=i.country;if(o?("string"!=typeof o||-1===t.inArray(o.toUpperCase(),this.COUNTRY_CODES))&&(o=e.getDynamicOption(a,o)):o=n.substr(0,2),-1===t.inArray(o,this.COUNTRY_CODES))return!0;var l=this[["_",o.toLowerCase()].join("")](n);return l=!0===l||!1===l?{valid:l}:l,l.message=FormValidation.Helper.format(i.message||FormValidation.I18n[s].vat.country,FormValidation.I18n[s].vat.countries[o.toUpperCase()]),l},_at:function(t){if(/^ATU[0-9]{8}$/.test(t)&&(t=t.substr(2)),!/^U[0-9]{8}$/.test(t))return!1;t=t.substr(1);for(var e=0,a=[1,2,1,2,1,2,1],i=0,r=0;7>r;r++)(i=parseInt(t.charAt(r),10)*a[r])>9&&(i=Math.floor(i/10)+i%10),e+=i;return 10===(e=10-(e+4)%10)&&(e=0),e+""===t.substr(7,1)},_be:function(t){return/^BE[0]{0,1}[0-9]{9}$/.test(t)&&(t=t.substr(2)),!!/^[0]{0,1}[0-9]{9}$/.test(t)&&(9===t.length&&(t="0"+t),"0"!==t.substr(1,1)&&(parseInt(t.substr(0,8),10)+parseInt(t.substr(8,2),10))%97==0)},_bg:function(t){if(/^BG[0-9]{9,10}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{9,10}$/.test(t))return!1;var e=0,a=0;if(9===t.length){for(a=0;8>a;a++)e+=parseInt(t.charAt(a),10)*(a+1);if(10===(e%=11))for(e=0,a=0;8>a;a++)e+=parseInt(t.charAt(a),10)*(a+3);return(e%=10)+""===t.substr(8)}if(10===t.length){return function(t){var e=parseInt(t.substr(0,2),10)+1900,a=parseInt(t.substr(2,2),10),i=parseInt(t.substr(4,2),10);if(a>40?(e+=100,a-=40):a>20&&(e-=100,a-=20),!FormValidation.Helper.date(e,a,i))return!1;for(var r=0,n=[2,4,8,5,10,9,7,3,6],s=0;9>s;s++)r+=parseInt(t.charAt(s),10)*n[s];return(r=r%11%10)+""===t.substr(9,1)}(t)||function(t){for(var e=0,a=[21,19,17,13,11,9,7,3,1],i=0;9>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return(e%=10)+""===t.substr(9,1)}(t)||function(t){for(var e=0,a=[4,3,2,7,6,5,4,3,2],i=0;9>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return 10!==(e=11-e%11)&&(11===e&&(e=0),e+""===t.substr(9,1))}(t)}return!1},_br:function(t){if(""===t)return!0;var e=t.replace(/[^\d]+/g,"");if(""===e||14!==e.length)return!1;if("00000000000000"===e||"11111111111111"===e||"22222222222222"===e||"33333333333333"===e||"44444444444444"===e||"55555555555555"===e||"66666666666666"===e||"77777777777777"===e||"88888888888888"===e||"99999999999999"===e)return!1;for(var a=e.length-2,i=e.substring(0,a),r=e.substring(a),n=0,s=a-7,o=a;o>=1;o--)n+=parseInt(i.charAt(a-o),10)*s--,2>s&&(s=9);var l=2>n%11?0:11-n%11;if(l!==parseInt(r.charAt(0),10))return!1;for(a+=1,i=e.substring(0,a),n=0,s=a-7,o=a;o>=1;o--)n+=parseInt(i.charAt(a-o),10)*s--,2>s&&(s=9);return(l=2>n%11?0:11-n%11)===parseInt(r.charAt(1),10)},_ch:function(t){if(/^CHE[0-9]{9}(MWST)?$/.test(t)&&(t=t.substr(2)),!/^E[0-9]{9}(MWST)?$/.test(t))return!1;t=t.substr(1);for(var e=0,a=[5,4,3,2,7,6,5,4],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return 10!==(e=11-e%11)&&(11===e&&(e=0),e+""===t.substr(8,1))},_cy:function(t){if(/^CY[0-5|9]{1}[0-9]{7}[A-Z]{1}$/.test(t)&&(t=t.substr(2)),!/^[0-5|9]{1}[0-9]{7}[A-Z]{1}$/.test(t))return!1;if("12"===t.substr(0,2))return!1;for(var e=0,a={0:1,1:0,2:5,3:7,4:9,5:13,6:15,7:17,8:19,9:21},i=0;8>i;i++){var r=parseInt(t.charAt(i),10);i%2==0&&(r=a[r+""]),e+=r}return(e="ABCDEFGHIJKLMNOPQRSTUVWXYZ"[e%26])+""===t.substr(8,1)},_cz:function(t){if(/^CZ[0-9]{8,10}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{8,10}$/.test(t))return!1;var e=0,a=0;if(8===t.length){if(t.charAt(0)+""=="9")return!1;for(e=0,a=0;7>a;a++)e+=parseInt(t.charAt(a),10)*(8-a);return 10===(e=11-e%11)&&(e=0),11===e&&(e=1),e+""===t.substr(7,1)}if(9===t.length&&t.charAt(0)+""=="6"){for(e=0,a=0;7>a;a++)e+=parseInt(t.charAt(a+1),10)*(8-a);return 10===(e=11-e%11)&&(e=0),11===e&&(e=1),(e=[8,7,6,5,4,3,2,1,0,9,10][e-1])+""===t.substr(8,1)}if(9===t.length||10===t.length){var i=1900+parseInt(t.substr(0,2),10),r=parseInt(t.substr(2,2),10)%50%20,n=parseInt(t.substr(4,2),10);if(9===t.length){if(i>=1980&&(i-=100),i>1953)return!1}else 1954>i&&(i+=100);if(!FormValidation.Helper.date(i,r,n))return!1;if(10===t.length){var s=parseInt(t.substr(0,9),10)%11;return 1985>i&&(s%=10),s+""===t.substr(9,1)}return!0}return!1},_de:function(t){return/^DE[0-9]{9}$/.test(t)&&(t=t.substr(2)),!!/^[0-9]{9}$/.test(t)&&FormValidation.Helper.mod11And10(t)},_dk:function(t){if(/^DK[0-9]{8}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{8}$/.test(t))return!1;for(var e=0,a=[2,7,6,5,4,3,2,1],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return e%11==0},_ee:function(t){if(/^EE[0-9]{9}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{9}$/.test(t))return!1;for(var e=0,a=[3,7,1,3,7,1,3,7,1],i=0;9>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return e%10==0},_es:function(t){if(/^ES[0-9A-Z][0-9]{7}[0-9A-Z]$/.test(t)&&(t=t.substr(2)),!/^[0-9A-Z][0-9]{7}[0-9A-Z]$/.test(t))return!1;var e=t.charAt(0);return/^[0-9]$/.test(e)?{valid:function(t){var e=parseInt(t.substr(0,8),10);return(e="TRWAGMYFPDXBNJZSQVHLCKE"[e%23])+""===t.substr(8,1)}(t),type:"DNI"}:/^[XYZ]$/.test(e)?{valid:function(t){var e=["XYZ".indexOf(t.charAt(0)),t.substr(1)].join("");return e=parseInt(e,10),(e="TRWAGMYFPDXBNJZSQVHLCKE"[e%23])+""===t.substr(8,1)}(t),type:"NIE"}:{valid:function(t){var e,a=t.charAt(0);if(-1!=="KLM".indexOf(a))return e=parseInt(t.substr(1,8),10),(e="TRWAGMYFPDXBNJZSQVHLCKE"[e%23])+""===t.substr(8,1);if(-1!=="ABCDEFGHJNPQRSUVW".indexOf(a)){for(var i=0,r=[2,1,2,1,2,1,2],n=0,s=0;7>s;s++)(n=parseInt(t.charAt(s+1),10)*r[s])>9&&(n=Math.floor(n/10)+n%10),i+=n;return 10===(i=10-i%10)&&(i=0),i+""===t.substr(8,1)||"JABCDEFGHI"[i]===t.substr(8,1)}return!1}(t),type:"CIF"}},_fi:function(t){if(/^FI[0-9]{8}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{8}$/.test(t))return!1;for(var e=0,a=[7,9,10,5,8,4,2,1],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return e%11==0},_fr:function(t){if(/^FR[0-9A-Z]{2}[0-9]{9}$/.test(t)&&(t=t.substr(2)),!/^[0-9A-Z]{2}[0-9]{9}$/.test(t))return!1;if(!FormValidation.Helper.luhn(t.substr(2)))return!1;if(/^[0-9]{2}$/.test(t.substr(0,2)))return t.substr(0,2)===parseInt(t.substr(2)+"12",10)%97+"";var e,a="0123456789ABCDEFGHJKLMNPQRSTUVWXYZ";return e=/^[0-9]{1}$/.test(t.charAt(0))?24*a.indexOf(t.charAt(0))+a.indexOf(t.charAt(1))-10:34*a.indexOf(t.charAt(0))+a.indexOf(t.charAt(1))-100,(parseInt(t.substr(2),10)+1+Math.floor(e/11))%11==e%11},_gb:function(t){if((/^GB[0-9]{9}$/.test(t)||/^GB[0-9]{12}$/.test(t)||/^GBGD[0-9]{3}$/.test(t)||/^GBHA[0-9]{3}$/.test(t)||/^GB(GD|HA)8888[0-9]{5}$/.test(t))&&(t=t.substr(2)),!(/^[0-9]{9}$/.test(t)||/^[0-9]{12}$/.test(t)||/^GD[0-9]{3}$/.test(t)||/^HA[0-9]{3}$/.test(t)||/^(GD|HA)8888[0-9]{5}$/.test(t)))return!1;var e=t.length;if(5===e){var a=t.substr(0,2),i=parseInt(t.substr(2),10);return"GD"===a&&500>i||"HA"===a&&i>=500}if(11===e&&("GD8888"===t.substr(0,6)||"HA8888"===t.substr(0,6)))return!("GD"===t.substr(0,2)&&parseInt(t.substr(6,3),10)>=500||"HA"===t.substr(0,2)&&parseInt(t.substr(6,3),10)<500)&&parseInt(t.substr(6,3),10)%97===parseInt(t.substr(9,2),10);if(9===e||12===e){for(var r=0,n=[8,7,6,5,4,3,2,10,1],s=0;9>s;s++)r+=parseInt(t.charAt(s),10)*n[s];return r%=97,parseInt(t.substr(0,3),10)>=100?0===r||42===r||55===r:0===r}return!0},_gr:function(t){if(/^(GR|EL)[0-9]{9}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{9}$/.test(t))return!1;8===t.length&&(t="0"+t);for(var e=0,a=[256,128,64,32,16,8,4,2],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return(e=e%11%10)+""===t.substr(8,1)},_el:function(t){return this._gr(t)},_hu:function(t){if(/^HU[0-9]{8}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{8}$/.test(t))return!1;for(var e=0,a=[9,7,3,1,9,7,3,1],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return e%10==0},_hr:function(t){return/^HR[0-9]{11}$/.test(t)&&(t=t.substr(2)),!!/^[0-9]{11}$/.test(t)&&FormValidation.Helper.mod11And10(t)},_ie:function(t){if(/^IE[0-9]{1}[0-9A-Z\*\+]{1}[0-9]{5}[A-Z]{1,2}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{1}[0-9A-Z\*\+]{1}[0-9]{5}[A-Z]{1,2}$/.test(t))return!1;var e=function(t){for(;t.length<7;)t="0"+t;for(var e="WABCDEFGHIJKLMNOPQRSTUV",a=0,i=0;7>i;i++)a+=parseInt(t.charAt(i),10)*(8-i);return a+=9*e.indexOf(t.substr(7)),e[a%23]};return/^[0-9]+$/.test(t.substr(0,7))?t.charAt(7)===e(t.substr(0,7)+t.substr(8)+""):-1==="ABCDEFGHIJKLMNOPQRSTUVWXYZ+*".indexOf(t.charAt(1))||t.charAt(7)===e(t.substr(2,5)+t.substr(0,1)+"")},_is:function(t){return/^IS[0-9]{5,6}$/.test(t)&&(t=t.substr(2)),/^[0-9]{5,6}$/.test(t)},_it:function(t){if(/^IT[0-9]{11}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{11}$/.test(t))return!1;if(0===parseInt(t.substr(0,7),10))return!1;var e=parseInt(t.substr(7,3),10);return!(1>e||e>201&&999!==e&&888!==e)&&FormValidation.Helper.luhn(t)},_lt:function(t){if(/^LT([0-9]{7}1[0-9]{1}|[0-9]{10}1[0-9]{1})$/.test(t)&&(t=t.substr(2)),!/^([0-9]{7}1[0-9]{1}|[0-9]{10}1[0-9]{1})$/.test(t))return!1;var e,a=t.length,i=0;for(e=0;a-1>e;e++)i+=parseInt(t.charAt(e),10)*(1+e%9);var r=i%11;if(10===r)for(i=0,e=0;a-1>e;e++)i+=parseInt(t.charAt(e),10)*(1+(e+2)%9);return(r=r%11%10)+""===t.charAt(a-1)},_lu:function(t){return/^LU[0-9]{8}$/.test(t)&&(t=t.substr(2)),!!/^[0-9]{8}$/.test(t)&&parseInt(t.substr(0,6),10)%89+""===t.substr(6,2)},_lv:function(t){if(/^LV[0-9]{11}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{11}$/.test(t))return!1;var e,a=parseInt(t.charAt(0),10),i=0,r=[],n=t.length;if(a>3){for(i=0,r=[9,1,4,8,3,10,2,5,7,6,1],e=0;n>e;e++)i+=parseInt(t.charAt(e),10)*r[e];return 3===(i%=11)}var s=parseInt(t.substr(0,2),10),o=parseInt(t.substr(2,2),10),l=parseInt(t.substr(4,2),10);if(l=l+1800+100*parseInt(t.charAt(6),10),!FormValidation.Helper.date(l,o,s))return!1;for(i=0,r=[10,5,8,4,2,1,6,3,7,9],e=0;n-1>e;e++)i+=parseInt(t.charAt(e),10)*r[e];return(i=(i+1)%11%10)+""===t.charAt(n-1)},_mt:function(t){if(/^MT[0-9]{8}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{8}$/.test(t))return!1;for(var e=0,a=[3,4,6,7,8,9,10,1],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return e%37==0},_nl:function(t){if(/^NL[0-9]{9}B[0-9]{2}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{9}B[0-9]{2}$/.test(t))return!1;for(var e=0,a=[9,8,7,6,5,4,3,2],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return(e%=11)>9&&(e=0),e+""===t.substr(8,1)},_no:function(t){if(/^NO[0-9]{9}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{9}$/.test(t))return!1;for(var e=0,a=[3,2,7,6,5,4,3,2],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return 11===(e=11-e%11)&&(e=0),e+""===t.substr(8,1)},_pl:function(t){if(/^PL[0-9]{10}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{10}$/.test(t))return!1;for(var e=0,a=[6,5,7,2,3,4,5,6,7,-1],i=0;10>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return e%11==0},_pt:function(t){if(/^PT[0-9]{9}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{9}$/.test(t))return!1;for(var e=0,a=[9,8,7,6,5,4,3,2],i=0;8>i;i++)e+=parseInt(t.charAt(i),10)*a[i];return(e=11-e%11)>9&&(e=0),e+""===t.substr(8,1)},_ro:function(t){if(/^RO[1-9][0-9]{1,9}$/.test(t)&&(t=t.substr(2)),!/^[1-9][0-9]{1,9}$/.test(t))return!1;for(var e=t.length,a=[7,5,3,2,1,7,5,3,2].slice(10-e),i=0,r=0;e-1>r;r++)i+=parseInt(t.charAt(r),10)*a[r];return(i=10*i%11%10)+""===t.substr(e-1,1)},_ru:function(t){if(/^RU([0-9]{10}|[0-9]{12})$/.test(t)&&(t=t.substr(2)),!/^([0-9]{10}|[0-9]{12})$/.test(t))return!1;var e=0;if(10===t.length){var a=0,i=[2,4,10,3,5,9,4,6,8,0];for(e=0;10>e;e++)a+=parseInt(t.charAt(e),10)*i[e];return(a%=11)>9&&(a%=10),a+""===t.substr(9,1)}if(12===t.length){var r=0,n=[7,2,4,10,3,5,9,4,6,8,0],s=0,o=[3,7,2,4,10,3,5,9,4,6,8,0];for(e=0;11>e;e++)r+=parseInt(t.charAt(e),10)*n[e],s+=parseInt(t.charAt(e),10)*o[e];return(r%=11)>9&&(r%=10),(s%=11)>9&&(s%=10),r+""===t.substr(10,1)&&s+""===t.substr(11,1)}return!1},_rs:function(t){if(/^RS[0-9]{9}$/.test(t)&&(t=t.substr(2)),!/^[0-9]{9}$/.test(t))return!1;for(var e=10,a=0,i=0;8>i;i++)0===(a=(parseInt(t.charAt(i),10)+e)%10)&&(a=10),e=2*a%11;return(e+parseInt(t.substr(8,1),10))%10==1},_se:function(t){return/^SE[0-9]{10}01$/.test(t)&&(t=t.substr(2)),!!/^[0-9]{10}01$/.test(t)&&(t=t.substr(0,10),FormValidation.Helper.luhn(t))},_si:function(t){var e=t.match(/^(SI)?([1-9][0-9]{7})$/);if(!e)return!1;e[1]&&(t=t.substr(2));for(var a=0,i=[8,7,6,5,4,3,2],r=0;7>r;r++)a+=parseInt(t.charAt(r),10)*i[r];return 10===(a=11-a%11)&&(a=0),a+""===t.substr(7,1)},_sk:function(t){return/^SK[1-9][0-9][(2-4)|(6-9)][0-9]{7}$/.test(t)&&(t=t.substr(2)),!!/^[1-9][0-9][(2-4)|(6-9)][0-9]{7}$/.test(t)&&parseInt(t,10)%11==0},_ve:function(t){if(/^VE[VEJPG][0-9]{9}$/.test(t)&&(t=t.substr(2)),!/^[VEJPG][0-9]{9}$/.test(t))return!1;for(var e={V:4,E:8,J:12,P:16,G:20}[t.charAt(0)],a=[3,2,7,6,5,4,3,2],i=0;8>i;i++)e+=parseInt(t.charAt(i+1),10)*a[i];return(11===(e=11-e%11)||10===e)&&(e=0),e+""===t.substr(9,1)},_za:function(t){return/^ZA4[0-9]{9}$/.test(t)&&(t=t.substr(2)),/^4[0-9]{9}$/.test(t)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{vin:{default:"Please enter a valid VIN number"}}}),FormValidation.Validator.vin={validate:function(t,e,a,i){var r=t.getFieldValue(e,i);if(""===r)return!0;if(!/^[a-hj-npr-z0-9]{8}[0-9xX][a-hj-npr-z0-9]{8}$/i.test(r))return!1;for(var n={A:1,B:2,C:3,D:4,E:5,F:6,G:7,H:8,J:1,K:2,L:3,M:4,N:5,P:7,R:9,S:2,T:3,U:4,V:5,W:6,X:7,Y:8,Z:9,1:1,2:2,3:3,4:4,5:5,6:6,7:7,8:8,9:9,0:0},s=[8,7,6,5,4,3,2,10,0,9,8,7,6,5,4,3,2],o=0,l=(r=r.toUpperCase()).length,d=0;l>d;d++)o+=n[r.charAt(d)+""]*s[d];var u=o%11;return 10===u&&(u="X"),u+""===r.charAt(8)}}}(jQuery),function(t){FormValidation.I18n=t.extend(!0,FormValidation.I18n||{},{en_US:{zipCode:{default:"Please enter a valid postal code",country:"Please enter a valid postal code in %s",countries:{AT:"Austria",BG:"Bulgaria",BR:"Brazil",CA:"Canada",CH:"Switzerland",CZ:"Czech Republic",DE:"Germany",DK:"Denmark",ES:"Spain",FR:"France",GB:"United Kingdom",IE:"Ireland",IN:"India",IT:"Italy",MA:"Morocco",NL:"Netherlands",PL:"Poland",PT:"Portugal",RO:"Romania",RU:"Russia",SE:"Sweden",SG:"Singapore",SK:"Slovakia",US:"USA"}}}}),FormValidation.Validator.zipCode={html5Attributes:{message:"message",country:"country"},COUNTRY_CODES:["AT","BG","BR","CA","CH","CZ","DE","DK","ES","FR","GB","IE","IN","IT","MA","NL","PL","PT","RO","RU","SE","SG","SK","US"],validate:function(e,a,i,r){var n=e.getFieldValue(a,r);if(""===n||!i.country)return!0;var s=e.getLocale(),o=i.country;if(("string"!=typeof o||-1===t.inArray(o,this.COUNTRY_CODES))&&(o=e.getDynamicOption(a,o)),!o||-1===t.inArray(o.toUpperCase(),this.COUNTRY_CODES))return!0;var l=!1;switch(o=o.toUpperCase()){case"AT":l=/^([1-9]{1})(\d{3})$/.test(n);break;case"BG":l=/^([1-9]{1}[0-9]{3})$/.test(t.trim(n));break;case"BR":l=/^(\d{2})([\.]?)(\d{3})([\-]?)(\d{3})$/.test(n);break;case"CA":l=/^(?:A|B|C|E|G|H|J|K|L|M|N|P|R|S|T|V|X|Y){1}[0-9]{1}(?:A|B|C|E|G|H|J|K|L|M|N|P|R|S|T|V|W|X|Y|Z){1}\s?[0-9]{1}(?:A|B|C|E|G|H|J|K|L|M|N|P|R|S|T|V|W|X|Y|Z){1}[0-9]{1}$/i.test(n);break;case"CH":l=/^([1-9]{1})(\d{3})$/.test(n);break;case"CZ":l=/^(\d{3})([ ]?)(\d{2})$/.test(n);break;case"DE":l=/^(?!01000|99999)(0[1-9]\d{3}|[1-9]\d{4})$/.test(n);break;case"DK":l=/^(DK(-|\s)?)?\d{4}$/i.test(n);break;case"ES":l=/^(?:0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/.test(n);break;case"FR":l=/^[0-9]{5}$/i.test(n);break;case"GB":l=this._gb(n);break;case"IN":l=/^\d{3}\s?\d{3}$/.test(n);break;case"IE":l=/^(D6W|[ACDEFHKNPRTVWXY]\d{2})\s[0-9ACDEFHKNPRTVWXY]{4}$/.test(n);break;case"IT":l=/^(I-|IT-)?\d{5}$/i.test(n);break;case"MA":l=/^[1-9][0-9]{4}$/i.test(n);break;case"NL":l=/^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i.test(n);break;case"PL":l=/^[0-9]{2}\-[0-9]{3}$/.test(n);break;case"PT":l=/^[1-9]\d{3}-\d{3}$/.test(n);break;case"RO":l=/^(0[1-8]{1}|[1-9]{1}[0-5]{1})?[0-9]{4}$/i.test(n);break;case"RU":l=/^[0-9]{6}$/i.test(n);break;case"SE":l=/^(S-)?\d{3}\s?\d{2}$/i.test(n);break;case"SG":l=/^([0][1-9]|[1-6][0-9]|[7]([0-3]|[5-9])|[8][0-2])(\d{4})$/i.test(n);break;case"SK":l=/^(\d{3})([ ]?)(\d{2})$/.test(n);break;case"US":default:l=/^\d{4,5}([\-]?\d{4})?$/.test(n)}return{valid:l,message:FormValidation.Helper.format(i.message||FormValidation.I18n[s].zipCode.country,FormValidation.I18n[s].zipCode.countries[o])}},_gb:function(t){for(var e="[ABCDEFGHIJKLMNOPRSTUWYZ]",a="[ABCDEFGHKLMNOPQRSTUVWXY]",i="[ABDEFGHJLNPQRSTUWXYZ]",r=[new RegExp("^("+e+"{1}"+a+"?[0-9]{1,2})(\\s*)([0-9]{1}"+i+"{2})$","i"),new RegExp("^("+e+"{1}[0-9]{1}[ABCDEFGHJKPMNRSTUVWXY]{1})(\\s*)([0-9]{1}"+i+"{2})$","i"),new RegExp("^("+e+"{1}"+a+"{1}?[0-9]{1}[ABEHMNPRVWXY]{1})(\\s*)([0-9]{1}"+i+"{2})$","i"),new RegExp("^(BF1)(\\s*)([0-6]{1}[ABDEFGHJLNPQRST]{1}[ABDEFGHJLNPQRSTUWZYZ]{1})$","i"),/^(GIR)(\s*)(0AA)$/i,/^(BFPO)(\s*)([0-9]{1,4})$/i,/^(BFPO)(\s*)(c\/o\s*[0-9]{1,3})$/i,/^([A-Z]{4})(\s*)(1ZZ)$/i,/^(AI-2640)$/i],n=0;n<r.length;n++)if(r[n].test(t))return!0;return!1}}}(jQuery);
/*!
 * FormValidation (http://formvalidation.io)
 * The best jQuery plugin to validate form fields. Support Bootstrap, Foundation, Pure, SemanticUI, UIKit and custom frameworks
 *
 * @version     v0.8.1, built on 2016-07-29 1:10:56 AM
 * @author      https://twitter.com/formvalidation
 * @copyright   (c) 2013 - 2016 Nguyen Huu Phuoc
 * @license     http://formvalidation.io/license/
 */
!function(a){FormValidation.Framework.Bootstrap=function(b,c,d){c=a.extend(!0,{button:{selector:'[type="submit"]:not([formnovalidate])',disabled:"disabled"},err:{clazz:"help-block",parent:"^(.*)col-(xs|sm|md|lg)-(offset-){0,1}[0-9]+(.*)$"},icon:{valid:null,invalid:null,validating:null,feedback:"form-control-feedback"},row:{selector:".form-group",valid:"has-success",invalid:"has-error",feedback:"has-feedback"}},c),FormValidation.Base.apply(this,[b,c,d])},FormValidation.Framework.Bootstrap.prototype=a.extend({},FormValidation.Base.prototype,{_fixIcon:function(a,b){var c=this._namespace,d=a.attr("type"),e=a.attr("data-"+c+"-field"),f=this.options.fields[e].row||this.options.row.selector,g=a.closest(f);if("checkbox"===d||"radio"===d){var h=a.parent();h.hasClass(d)?b.insertAfter(h):h.parent().hasClass(d)&&b.insertAfter(h.parent())}0!==g.find(".input-group").length&&b.addClass("fv-bootstrap-icon-input-group").insertAfter(g.find(".input-group").eq(0))},_createTooltip:function(a,b,c){var d=this._namespace,e=a.data(d+".icon");if(e)switch(c){case"popover":e.css({cursor:"pointer","pointer-events":"auto"}).popover("destroy").popover({container:"body",content:b,html:!0,placement:"auto top",trigger:"hover click"});break;case"tooltip":default:e.css({cursor:"pointer","pointer-events":"auto"}).tooltip("destroy").tooltip({container:"body",html:!0,placement:"auto top",title:b})}},_destroyTooltip:function(a,b){var c=this._namespace,d=a.data(c+".icon");if(d)switch(b){case"popover":d.css({cursor:"","pointer-events":"none"}).popover("destroy");break;case"tooltip":default:d.css({cursor:"","pointer-events":"none"}).tooltip("destroy")}},_hideTooltip:function(a,b){var c=this._namespace,d=a.data(c+".icon");if(d)switch(b){case"popover":d.popover("hide");break;case"tooltip":default:d.tooltip("hide")}},_showTooltip:function(a,b){var c=this._namespace,d=a.data(c+".icon");if(d)switch(b){case"popover":d.popover("show");break;case"tooltip":default:d.tooltip("show")}}}),a.fn.bootstrapValidator=function(b){var c=arguments;return this.each(function(){var d=a(this),e=d.data("formValidation")||d.data("bootstrapValidator"),f="object"==typeof b&&b;e||(e=new FormValidation.Framework.Bootstrap(this,a.extend({},{events:{formInit:"init.form.bv",formPreValidate:"prevalidate.form.bv",formError:"error.form.bv",formSuccess:"success.form.bv",fieldAdded:"added.field.bv",fieldRemoved:"removed.field.bv",fieldInit:"init.field.bv",fieldError:"error.field.bv",fieldSuccess:"success.field.bv",fieldStatus:"status.field.bv",localeChanged:"changed.locale.bv",validatorError:"error.validator.bv",validatorSuccess:"success.validator.bv"}},f),"bv"),d.addClass("fv-form-bootstrap").data("formValidation",e).data("bootstrapValidator",e)),"string"==typeof b&&e[b].apply(e,Array.prototype.slice.call(c,1))})},a.fn.bootstrapValidator.Constructor=FormValidation.Framework.Bootstrap}(jQuery);
/*!
 * FormValidation (http://formvalidation.io)
 * The best jQuery plugin to validate form fields. Support Bootstrap, Foundation, Pure, SemanticUI, UIKit and custom frameworks
 *
 * @version     v0.8.1, built on 2016-07-29 1:10:56 AM
 * @author      https://twitter.com/formvalidation
 * @copyright   (c) 2013 - 2016 Nguyen Huu Phuoc
 * @license     http://formvalidation.io/license/
 */
!function(a){FormValidation.Framework.Bootstrap4=function(b,c,d){c=a.extend(!0,{button:{selector:'[type="submit"]:not([formnovalidate])',disabled:"disabled"},err:{clazz:"form-control-label",parent:"^(.*)(col|offset)-(xs|sm|md|lg)-[0-9]+(.*)$"},icon:{valid:null,invalid:null,validating:null,feedback:"fv-control-feedback"},row:{selector:".form-group",valid:"has-success",invalid:"has-danger",feedback:"fv-has-feedback"}},c),FormValidation.Base.apply(this,[b,c,d])},FormValidation.Framework.Bootstrap4.prototype=a.extend({},FormValidation.Base.prototype,{_fixIcon:function(a,b){var c=this._namespace,d=a.attr("type"),e=a.attr("data-"+c+"-field"),f=this.options.fields[e].row||this.options.row.selector,g=a.closest(f);if("checkbox"===d||"radio"===d){var h=a.parent();h.hasClass("form-check")?b.insertAfter(h):h.parent().hasClass("form-check")&&b.insertAfter(h.parent())}0!==g.find(".input-group").length&&b.addClass("fv-bootstrap-icon-input-group").insertAfter(g.find(".input-group").eq(0))},_createTooltip:function(a,b,c){var d=this._namespace,e=a.data(d+".icon");if(e)switch(c){case"popover":e.css({cursor:"pointer","pointer-events":"auto"}).popover("destroy").popover({container:"body",content:b,html:!0,placement:"top",trigger:"hover click"});break;case"tooltip":default:e.css({cursor:"pointer","pointer-events":"auto"}).tooltip("dispose").tooltip({container:"body",html:!0,placement:"top",title:b})}},_destroyTooltip:function(a,b){var c=this._namespace,d=a.data(c+".icon");if(d)switch(b){case"popover":d.css({cursor:"","pointer-events":"none"}).popover("destroy");break;case"tooltip":default:d.css({cursor:"","pointer-events":"none"}).tooltip("dispose")}},_hideTooltip:function(a,b){var c=this._namespace,d=a.data(c+".icon");if(d)switch(b){case"popover":d.popover("hide");break;case"tooltip":default:d.tooltip("hide")}},_showTooltip:function(a,b){var c=this._namespace,d=a.data(c+".icon");if(d)switch(b){case"popover":d.popover("show");break;case"tooltip":default:d.tooltip("show")}}})}(jQuery);
$(function(){
    // 验证码输入自动转为大写
    $(document).on('change keyup','.input-codeimg',function(){
        $(this).val($(this).val().toUpperCase());
    });
    // 上传文件
    $(document).on("change keyup",".input-group-file input[type=file]",function(){
        var $self=$(this),
            $text=$(this).parents('.input-group-file').find('.form-control'),
            value="";
        if(is_lteie9) value=$(this).val();
        if(!value){
            $.each($self[0].files,function(i,file){
                if(i>0 ) value +=',';
                value +=file.name;
            });
        }
        $text.val(value);
    });
    // 验证码点击刷新
    $(document).on('click',"#getcode",function(){
        var data_src=$(this).attr("data-src");
        if(!data_src){
            data_src=$(this).prop("src")+'&random=';
            $(this).attr({'data-src':data_src});
        }
        $(this).attr({src:data_src+Math.floor(Math.random()*9999+1)});
    });
});
// 表单验证通用
$.fn.validation=function(){
    var $self=$(this),
        self_validation=$(this).formValidation({
        locale:validation_locale,
        framework:'bootstrap4'
    });
    // 表单所处弹窗隐藏时重置验证
    $(this).parents('.modal').on('hide.bs.modal',function() {
        $self.data('formValidation').resetForm();
    });
    function success(func,afterajax_ok){
        self_validation.on('success.form.fv', function(e) {
            e.preventDefault();
            var ajax_ok=typeof afterajax_ok != "undefined" ?afterajax_ok:true;
            if(ajax_ok){
                formDataAjax(e,func);
            }else{
                $self.data('formValidation').resetForm();
                if (typeof func==="function") return func(e,$self);
            }
        })
    }
    function formDataAjax(e,func){
        var $form    = $(e.target);
        if(is_lteie9){
            var formData = $form.serializeArray(),
                contentType='application/x-www-form-urlencoded',
                processData=true;
        }else{
            var formData = new FormData(),
                params   = $form.serializeArray(),
                contentType=false,
                processData=false;
            $.each(params, function(i, val) {
                formData.append(val.name, val.value);
            });
        }
        $.ajax({
            url: $form.attr('action'),
            data: formData,
            cache: false,
            contentType: contentType,
            processData: processData,
            type: 'POST',
            dataType:'json',
            success: function(result) {
                $form.data('formValidation').resetForm();
                if (typeof func==="function") return func(result,$form);
            }
        });
    }
    return {success:success,formDataAjax:formDataAjax};
}
// formValidation多语言选择
window.validation_locale='';
if("undefined" != typeof M && M['plugin_lang']){
    validation_locale=M['lang']+'_';
    switch(M['lang']){
        case 'sq':validation_locale+='AL';break;
        case 'ar':validation_locale+='MA';break;
        // case 'az':validation_locale+='az';break;
        // case 'ga':validation_locale+='ie';break;
        // case 'et':validation_locale+='ee';break;
        case 'be':validation_locale+='BE';break;
        case 'bg':validation_locale+='BG';break;
        case 'pl':validation_locale+='PL';break;
        case 'fa':validation_locale+='IR';break;
        // case 'af':validation_locale+='za';break;
        case 'da':validation_locale+='DK';break;
        case 'de':validation_locale+='DE';break;
        case 'ru':validation_locale+='RU';break;
        case 'fr':validation_locale+='FR';break;
        // case 'tl':validation_locale+='ph';break;
        case 'fi':validation_locale+='FI';break;
        // case 'ht':validation_locale+='ht';break;
        // case 'ko':validation_locale+='kr';break;
        case 'nl':validation_locale+='NL';break;
        // case 'gl':validation_locale+='es';break;
        case 'ca':validation_locale+='ES';break;
        case 'cs':validation_locale+='CZ';break;
        // case 'hr':validation_locale+='hr';break;
        // case 'la':validation_locale+='IT';break;
        // case 'lv':validation_locale+='lv';break;
        // case 'lt':validation_locale+='lt';break;
        case 'ro':validation_locale+='RO';break;
        // case 'mt':validation_locale+='mt';break;
        // case 'ms':validation_locale+='ID';break;
        // case 'mk':validation_locale+='mk';break;
        case 'no':validation_locale+='NO';break;
        case 'pt':validation_locale+='PT';break;
        case 'ja':validation_locale+='JP';break;
        case 'sv':validation_locale+='SE';break;
        case 'sr':validation_locale+='RS';break;
        case 'sk':validation_locale+='SK';break;
        // case 'sl':validation_locale+='si';break;
        // case 'sw':validation_locale+='tz';break;
        case 'th':validation_locale+='TH';break;
        // case 'cy':validation_locale+='wls';break;
        // case 'uk':validation_locale+='ua';break;
        // case 'iw':validation_locale+='';break;
        case 'el':validation_locale+='GR';break;
        case 'eu':validation_locale+='ES';break;
        case 'es':validation_locale+='ES';break;
        case 'hu':validation_locale+='HU';break;
        case 'it':validation_locale+='IT';break;
        // case 'yi':validation_locale+='de';break;
        // case 'ur':validation_locale+='pk';break;
        case 'id':validation_locale+='ID';break;
        case 'en':validation_locale+='US';break;
        case 'vi':validation_locale+='VN';break;
        case 'tc':validation_locale='zh_TW';break;
        case 'cn':validation_locale='zh_CN';break;
    }
}else{
    validation_locale='zh_CN';
}
// 表单验证初始化
if($(".met-form-validation").length) {
    window.validate=new Array();
    $(".met-form-validation").each(function(index, el) {
        validate[index]=$(el).validation();
    });
}
$(function(){
	// 翻页ajax加载
	if($(".met-pager-ajax").length){
		var $met_pager=$('.met_pager'),
			$metpagerajax_link=$(".met-pager-ajax-link");
		if($met_pager.length){
			if($metpagerajax_link.hasClass("hidden-md-up")){
				Breakpoints.on('xs',{
	            	enter:function(){
						metpagerajax();
					}
				});
			}else{
				metpagerajax();
			}
	        setTimeout(function(){
				$metpagerajax_link.scrollFun(function(val){
		            val.appearDiy();
				});
			},0)
		}
		if($(".met_pager a").length==1 || !$('.met_pager').length){
			$(".met_pager").attr({hidden:''});
			$metpagerajax_link.attr({hidden:''});
		}
	}
});
// 分页脚本
function metpagerajax(){
	var $metpagerbtn=$("#met-pager-btn"),
		$metpagerajax=$(".met-pager-ajax"),
		pagemax=$(".met_pager a").length-1,
		page=$('#metPageT').val(),
		metpagerbtnText=function(){
			if(pagemax){
				if(pagemax <= page && page>1) $metpagerbtn.addClass('disabled').text('已经是最后一页了');
			}else{
				$metpagerbtn.attr({hidden:''});
			}
		};
	metpagerbtnText();
	$metpagerbtn.click(function(){
		if(!$metpagerbtn.hasClass('disabled')){
			page++;
			var pageurl=$('#metPageT').data('pageurl').split('&page=')[0];
			$.ajax({
				url:pageurl,
				type:'POST',
				data:{ajax:1,page:page},
				success:function(data){
					var $data=$(data).find('.met-pager-ajax');
					if($data.length){// 如果模板直接调用ui_ajax中的文件
						$data.find('>').addClass('page'+page).removeClass('shown');
						data=$data.html();
					}
					$metpagerajax.append(data);
					metpagerajaxFun(page);
					metpagerbtnText();
				}
			});
		}
	});
}
// 无刷新分页获取到数据追加到页面后，可以在此方法继续处理
function metpagerajaxFun(page){
	var $metpagerajax=$('.met-pager-ajax'),
		metpager_original='.page'+page+' [data-original]';
	if($metpagerajax.find(metpager_original).length){
		// 图片高度预设
		// setTimeout(function(){
			$metpagerajax.imageSize(metpager_original);
		// },0)
		// 图片延迟加载
	    if($metpagerajax.find(metpager_original).length) $metpagerajax.find(metpager_original).lazyload({placeholder:met_lazyloadbg});
		setTimeout(function(){
			$('html,body').stop().animate({scrollTop:$(window).scrollTop()+2},0);
	    },300)
	}
	if($('#met-grid').length){
		setTimeout(function(){
			if(typeof metAnimOnScroll != 'undefined') metAnimOnScroll('met-grid');// 产品模块瀑布流
		},0)
	}
}
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
				m_title=m_title?'<a title="'+m_title+'"><b>'+m_title+'</b></a>':'';
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
				$(this).attr('title',$(this).attr('title').replace('繁','简'));
				$(this).find('i').text('简');
			}else{
				$('body').t2s();
				isSimplified=true;
				$(this).attr('title',$(this).attr('title').replace('简','繁'));
				$(this).find('i').text('繁');
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
				if(s==2){
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
				$(this).attr('title',$(this).attr('title').replace('繁','简'));
				$(this).find('i').text('简');
			}else{
				$('body').t2s();
				isSimplified=true;
				$(this).attr('title',$(this).attr('title').replace('简','繁'));
				$(this).find('i').text('繁');
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


METUI_FUN['message_met_m1156_1']=METUI['message_met_m1156_1_x']={
	name: 'message_met_m1156_1',
	init: function(){
		if($('.swiper-header').length==0){
			METUI['message_met_m1156_1_x'].slide(1);
		}
		METUI['message_met_m1156_1'].find('.message-subpage .form-group').each(function(){
			var html=$(this).html();
			if(html.indexOf('input')>0&&html.indexOf('text')>0&&html.indexOf('placeholder')>0){
				$(this).addClass('ftype_input').html('<div>'+html+'</div>');
			}
			else if(html.indexOf('textarea')>0){
				$(this).addClass('ftype_textarea').html('<div>'+html+'</div>');
			}
			else if(html.indexOf('select')>0){
				$(this).addClass('ftype_select').html('<div>'+html+'</div>');
			}
			else if(html.indexOf('radio')>0){
				$(this).addClass('ftype_radio').html(html.replace('</label>','</label><div>')+'</div>');
			}
			else if(html.indexOf('checkbox')>0){
				$(this).addClass('ftype_checkbox').html(html.replace('</label>','</label><div>')+'</div>');
			}
			else if(html.indexOf('input-group-file')>0){
				$(this).addClass('ftype_upload').html(html.replace('</label>','</label><div>')+'</div>');
			}
			else if(html.indexOf('submit')>0){
				$(this).addClass('submint').removeClass('form-group').html(html);
				$(this).find('button').html('<span>'+$(this).find('button').html()+'</span>');
			}
		});
		METUI['message_met_m1156_1'].find('.message-subpage #getcode').click(function(){
			$(this).attr('src',$(this).attr('src'));
		});
	},
	resize: function(res){
		
		if(!res) $(window).resize(function(){ METUI['message_met_m1156_1_x'].resize(true); });
	},
	slide: function(str){
		switch (str){
			case 1:
				if(!METUI['slide']){
					METUI['message_met_m1156_1']
						.css('background-image','url('+METUI['message_met_m1156_1'].attr('data-background')+')')
						.removeAttr('data-background')
				}				
			break;
			case 2:
			
			break;
			case 3:
			
			break;
		}
	},
	maps: function(){
		if($('script[map=message_met_m1156_1]').length==0){
			$('body').append(
				"<script src=//api.map.baidu.com/api?v=2.0&ak=aL2Gwp389Kxj3bFhSMq7cf9w&callback=METUI['message_met_m1156_1_x'].maps map=message_met_m1156_1></script>");
		}else{
			var icon='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAA'+
					 'Cnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=',
				coordinate=METUI['message_met_m1156_1'].find('.contact-map').attr('coordinate')||'105,25',
				level=METUI['message_met_m1156_1'].find('.contact-map').attr('level')||14,
				dark=METUI['message_met_m1156_1'].find('.contact-map').attr('dark')==1,
				coo=coordinate&&coordinate.split(',');
			var map=new BMap.Map("message_met_m1156_1_map");
			map.centerAndZoom(new BMap.Point(118.065182,24.60812),level);
			map.enableScrollWheelZoom(); 
			if(dark) map.setMapStyle({style:"dark"});
			var Icon = new BMap.Icon(icon+"\" class=\"point-img\"><span></span><br id=\"", new BMap.Size(28,56));
			var marker = new BMap.Marker(new BMap.Point(118.065182,24.60812),{icon:Icon});
			marker.setAnimation(BMAP_ANIMATION_BOUNCE); 
			map.addOverlay(marker);
		}
	}
}
var x=new metui(METUI_FUN['message_met_m1156_1']);

