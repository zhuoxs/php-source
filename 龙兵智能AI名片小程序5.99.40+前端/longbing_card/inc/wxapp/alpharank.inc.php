<?php
define( 'ROOT_PATH', IA_ROOT . '/addons/longbing_card/' );
is_file( ROOT_PATH . '/inc/we7.php' ) or exit( 'Access Denied Longbing' );
require_once ROOT_PATH . '/inc/we7.php';

/**
 * @Purpose: boss端销售排行--按照客户人数排名
 *
 * @Author: zzf
 *
 * @Return: mixed 查询返回值（结果集对象）
 */

global $_GPC, $_W;
$uniacid = $_W[ 'uniacid' ];
$sign    = $_GPC[ 'sign' ]; //   1 => 客户总数; 2 => 新增客户
$type    = $_GPC[ 'type' ]; //   1 => 昨日; 2 => 近7天; 3 => 近15天; 4 => 近30天; 仅当$sign = 2时有效
$refresh = $_GPC[ 'refresh' ];

$uid = $_GPC['user_id'];

$data = array(
    'list'        => [],
    'page'        => 1,
    'total_count' => 0,
    'total_page'  => 0
);

$check_is_boss = lbSingleChecklAlphaAuth( $uid );

$checkBossAuth = lbSingleCheckBoss($uniacid);

if (is_numeric($checkBossAuth) && $checkBossAuth != 1)
{
    $check_is_boss = 0;
}

//  没有权限返回空数据
if ( is_numeric($check_is_boss) && $check_is_boss < 0 ) {
    return $this->result( 0, '', $data );
}
if ( !$sign ) {
    $sign = 1;
}
if ( !$type ) {
    $type = 1;
}


$curr = 1;
if ( isset( $_GPC[ 'page' ] ) ) {
    $curr = $_GPC[ 'page' ];
}
$offset = ( $curr - 1 ) * 20;

//  判断有没有缓存
$cacheKey  = "alphaRank_com{$check_is_boss}_un{$uniacid}_type{$type}_sign{$sign}";
$cacheData = lbSingleAlphaCacheData( $cacheKey, $uniacid );

if ( $cacheData && !$refresh ) {
    $array = array_slice( $cacheData, $offset, 20 );
    $data  = [
        'page'        => $curr,
        'total_page'  => ceil( count( $cacheData ) / 20 ),
        'list'        => $array,
        'total_count' => count( $cacheData )
    ];

    $data['dataSource'] = 'cache';
    return $this->result( 0, '', $data );
}

if ( $refresh ) {

    lbSingleAlphaDeleteCache( "alphaRank_com{$check_is_boss}_un{$uniacid}_type1_sign1", $uniacid );
    lbSingleAlphaDeleteCache( "alphaRank_com{$check_is_boss}_un{$uniacid}_type1_sign2", $uniacid );
    lbSingleAlphaDeleteCache( "alphaRank_com{$check_is_boss}_un{$uniacid}_type2_sign2", $uniacid );
    lbSingleAlphaDeleteCache( "alphaRank_com{$check_is_boss}_un{$uniacid}_type3_sign2", $uniacid );
    lbSingleAlphaDeleteCache( "alphaRank_com{$check_is_boss}_un{$uniacid}_type4_sign2", $uniacid );
    //    return $this->result( 0, '', '数据更新中，更新时间以后台数据量多少决定，请耐心等待2-5分钟，建议每天最多更新一次' );
    echo json_encode( [
            'errno'   => -2,
            'message' => '数据更新中，更新时间以后台数据量多少决定，请耐心等待2-5分钟，建议每天最多更新一次',
            'data'    => []
        ]
    );
    //直接输出
    if ( function_exists( 'fastcgi_finish_request' ) ) {
        @fastcgi_finish_request();
    }
}

if ( $check_is_boss ) {
    $cardsStr = lbSingleAlphaCardsStr( $check_is_boss, $uniacid );
    $cardsArr = explode( ',', $cardsStr );
}

if ( $sign == 1 ) {
    if ( is_array( $cardsArr ) && !empty( $cardsArr ) )
    {
        $sql  = "SELECT count(id) as total, to_uid FROM " .
            tablename( 'longbing_card_collection' ) .
            " WHERE uid != to_uid && uniacid = {$uniacid} && to_uid IN ({$cardsStr}) GROUP BY to_uid";
    }
    else
    {
        $sql  = "SELECT count(id) as total, to_uid FROM " .
            tablename( 'longbing_card_collection' ) .
            " WHERE uid != to_uid && uniacid = {$uniacid} GROUP BY to_uid";
    }

    $list = pdo_fetchall( $sql );

    if ( is_array( $cardsArr ) && !empty( $cardsArr ) )
    {
        $staffs = pdo_fetchall( "SELECT a.id,a.name,a.avatar,a.create_time,a.fans_id,b.nickName,b.avatarUrl FROM " . tablename(
            'longbing_card_user_info' ) . " a LEFT JOIN " . tablename( 'longbing_card_user' ) . " b ON a.fans_id = b.id where a.status = 1 && b.is_staff = 1 && a.uniacid = {$uniacid} && a.fans_id > 0 && a.fans_id in ($cardsStr)" );
    }
    else
    {
        $staffs = pdo_fetchall( "SELECT a.id,a.name,a.avatar,a.create_time,a.fans_id,b.nickName,b.avatarUrl FROM " . tablename(
            'longbing_card_user_info' ) . " a LEFT JOIN " . tablename( 'longbing_card_user' ) . " b ON a.fans_id = b.id where a.status = 1 && b.is_staff = 1 && a.uniacid = {$uniacid} && a.fans_id > 0" );
    }

    foreach ( $staffs as $k => $v ) {
        $staffs[ $k ][ 'count' ]  = 0;
        $staffs[ $k ][ 'avatar' ] = tomedia( $v[ 'avatar' ] );
        foreach ( $list as $k2 => $v2 ) {
            if ( $v2[ 'to_uid' ] == $v[ 'fans_id' ] ) {
                $staffs[ $k ][ 'count' ] = $v2[ 'total' ];
            }
        }
    }
    array_multisort( array_column( $staffs, 'count' ), SORT_DESC, $staffs );
    foreach ( $staffs as $k => $v ) {
        $staffs[ $k ][ 'sort' ] = $k + 1;
    }

    lbSingleAlphaSaveCacheData( $cacheKey, $uniacid, $staffs );
    $array = array_slice( $staffs, $offset, 20 );
    $data  = [
        'page'        => $curr,
        'total_page'  => ceil( count( $staffs ) / 20 ),
        'list'        => $array,
        'total_count' => count( $staffs )
    ];

    return $this->result( 0, '', $data );
}

$beginTime = 0;
switch ( $type ) {
    case 2://   2=>近七天数据
        // 七天前开始的的时间戳
        $beginTime = mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - 7, date( 'Y' ) );
        break;
    case 3://   3=>近15天数据
        // 15天前开始的的时间戳
        $beginTime = mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - 15, date( 'Y' ) );
        break;
    case 4://   3=>近30天数据
        $beginTime = mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - 30, date( 'Y' ) );
        break;
    default://  1=>今日数据
        // 今天开始的的时间戳
        $beginTime = mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - 1, date( 'Y' ) );
    // 今天结束的时间戳
    //                $endTime = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
}

if ( is_array( $cardsArr ) && !empty( $cardsArr ) )
{
    $sql  = "SELECT count(id) as total, to_uid FROM " . tablename( 'longbing_card_collection' ) . " WHERE uid != to_uid && uniacid = {$uniacid} && create_time > {$beginTime} && to_uid IN ({$cardsStr}) GROUP BY to_uid";
}
else
{
    $sql  = "SELECT count(id) as total, to_uid FROM " . tablename( 'longbing_card_collection' ) . " WHERE uid != to_uid && uniacid = {$uniacid} && create_time > {$beginTime} GROUP BY to_uid";
}

$list = pdo_fetchall( $sql );

if ( is_array( $cardsArr ) && !empty( $cardsArr ) )
{
    $staffs = pdo_fetchall( "SELECT a.id,a.name,a.avatar,a.create_time,a.fans_id,b.nickName,b.avatarUrl FROM " . tablename( 'longbing_card_user_info' ) . " a LEFT JOIN " . tablename( 'longbing_card_user' ) . " b ON a.fans_id = b.id where a.status = 1 && b.is_staff = 1 && a.uniacid = {$uniacid} && fans_id IN ({$cardsStr})" );
}
else
{
    $staffs = pdo_fetchall( "SELECT a.id,a.name,a.avatar,a.create_time,a.fans_id,b.nickName,b.avatarUrl FROM " . tablename( 'longbing_card_user_info' ) . " a LEFT JOIN " . tablename( 'longbing_card_user' ) . " b ON a.fans_id = b.id where a.status = 1 && b.is_staff = 1 && a.uniacid = {$uniacid}" );
}


foreach ( $staffs as $k => $v ) {
    $staffs[ $k ][ 'count' ]  = 0;
    $staffs[ $k ][ 'avatar' ] = tomedia( $v[ 'avatar' ] );
    foreach ( $list as $k2 => $v2 ) {
        if ( $v2[ 'to_uid' ] == $v[ 'fans_id' ] ) {
            $staffs[ $k ][ 'count' ] = $v2[ 'total' ];
        }
    }
}

array_multisort( array_column( $staffs, 'count' ), SORT_DESC, $staffs );

foreach ( $staffs as $k => $v ) {
    $staffs[ $k ][ 'sort' ] = $k + 1;
}

lbSingleAlphaSaveCacheData( $cacheKey, $uniacid, $staffs );
$array = array_slice( $staffs, $offset, 20 );
$data  = [
    'page'        => $curr,
    'total_page'  => ceil( count( $staffs ) / 20 ),
    'list'        => $array,
    'total_count' => count( $staffs )
];

return $this->result( 0, '', $data );