<?
include_once dirname(__FILE__)."/../config/config.php";

require_once WWWPATH."/includes/login_check.php";
require_once WWWPATH."/includes/filter_getpost.php";
include_once WWWPATH."/includes/functions.php";


// ------------ IN | OUT (START) -------------
if(isset($_POST['io_mode'])){
    $exec = "/bin/sed -i 's/io_mode=.*/io_mode=\\\"".$_POST['io_mode']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['ap_mode'])){
    $exec = "/bin/sed -i 's/ap_mode=.*/ap_mode=\\\"".$_POST['ap_mode']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);

    if($_POST['ap_mode'] == "2") {
        $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"at0\\\";/g' ../config/config.php";
		exec_fruitywifi($exec);

        $exec = "/bin/sed -i 's/interface=.*/interface=at0/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
		exec_fruitywifi($exec);
    } else {
        $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"$io_in_iface\\\";/g' ../config/config.php";
		exec_fruitywifi($exec);

        $exec = "/bin/sed -i 's/interface=.*/interface=$io_in_iface/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
		exec_fruitywifi($exec);
    }
}

if(isset($_POST['io_action'])){
    $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"".$_POST['io_action']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['io_in_iface'])){
    $exec = "/bin/sed -i 's/io_in_iface=.*/io_in_iface=\\\"".$_POST['io_in_iface']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);

    // replace interface in hostapd.conf and hostapd-secure.conf
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST['io_in_iface']."/g' /usr/share/fruitywifi/conf/hostapd.conf";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST['io_in_iface']."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
    exec_fruitywifi($exec);

    $exec = "/bin/sed -i 's/interface=.*/interface=".$_POST['io_in_iface']."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);

    //EXTRACT MACADDRESS
    $exec = "/sbin/ifconfig -a ".$_POST['io_in_iface']." |grep HWaddr";
    $output = exec_fruitywifi($exec);
    $output = preg_replace('/\s+/', ' ',$output);
    $output = explode(" ",$output);

    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/fruitywifi/conf/hostapd.conf";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
    exec_fruitywifi($exec);

    // IF AP_MODE IS AIRMON-NG KEEPS AT0 IN DNSMASQ
    if($ap_mode == "2") {
        $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"at0\\\";/g' ../config/config.php";
		exec_fruitywifi($exec);

        $exec = "/bin/sed -i 's/interface=.*/interface=at0/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
		exec_fruitywifi($exec);
    } else {
        $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"".$_POST['io_in_iface']."\\\";/g' ../config/config.php";
		exec_fruitywifi($exec);

        $exec = "/bin/sed -i 's/interface=.*/interface=".$_POST['io_in_iface']."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
		exec_fruitywifi($exec);
    }
}

if(isset($_POST['io_in_set'])){
    $exec = "/bin/sed -i 's/io_in_set=.*/io_in_set=\\\"".$_POST['io_in_set']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['io_in_ip'])){
    $exec = "/bin/sed -i 's/io_in_ip=.*/io_in_ip=\\\"".$_POST['io_in_ip']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);

    // DNSMASQ (replace ip)
    $exec = "/bin/sed -i 's/server=.*/server=\/\#\/".$_POST['io_in_ip']."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);

    $exec = "/bin/sed -i 's/listen-address=.*/listen-address=".$_POST['io_in_ip']."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);

    $ip = explode(".",$_POST['io_in_ip']);
    $sub = $ip[0] . "." . $ip[1] . "." . $ip[2];

    $exec = "/bin/sed -i 's/dhcp-range=.*/dhcp-range=".$sub.".50,".$sub.".100,12h/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);
}

if(isset($_POST['io_in_mask'])){
    $exec = "/bin/sed -i 's/io_in_mask=.*/io_in_mask=\\\"".$_POST['io_in_mask']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['io_in_gw'])){
    $exec = "/bin/sed -i 's/io_in_gw=.*/io_in_gw=\\\"".$_POST['io_in_gw']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['io_out_iface'])){
    $exec = "/bin/sed -i 's/io_out_iface=.*/io_out_iface=\\\"".$_POST['io_out_iface']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['io_out_set'])){
    $exec = "/bin/sed -i 's/io_out_set=.*/io_out_set=\\\"".$_POST['io_out_set']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['io_out_ip'])){
    $exec = "/bin/sed -i 's/io_out_ip=.*/io_out_ip=\\\"".$_POST['io_out_ip']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['io_out_mask'])){
    $exec = "/bin/sed -i 's/io_out_mask=.*/io_out_mask=\\\"".$_POST['io_out_mask']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['io_out_gw'])){
    $exec = "/bin/sed -i 's/io_out_gw=.*/io_out_gw=\\\"".$_POST['io_out_gw']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

// ------------ IN | OUT (END) -------------

if(isset($_POST['iface']) and $_POST['iface'] == "internet"){
    $exec = "/bin/sed -i 's/io_out_iface=.*/io_out_iface=\\\"".$_POST['io_out_iface']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['iface']) and $_POST['iface'] == "wifi"){
    $exec = "/bin/sed -i 's/io_in_iface=.*/io_in_iface=\\\"".$_POST['io_in_iface']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);

    // replace interface in hostapd.conf and hostapd-secure.conf
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST['io_in_iface']."/g' /usr/share/fruitywifi/conf/hostapd.conf";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST['io_in_iface']."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
    exec_fruitywifi($exec);

    $exec = "/bin/sed -i 's/interface=.*/interface=".$_POST['io_in_iface']."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);

    //EXTRACT MACADDRESS
    $exec = "/sbin/ifconfig -a ".$_POST['io_in_iface']." |grep HWaddr";
    $output = exec_fruitywifi($exec);
    $output = preg_replace('/\s+/', ' ',$output);
    $output = explode(" ",$output);

    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/fruitywifi/conf/hostapd.conf";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
    exec_fruitywifi($exec);

}

if(isset($_POST['iface']) and $_POST['iface'] == "wifi_extra"){
    $exec = "/bin/sed -i 's/io_in_iface_extra=.*/io_in_iface_extra=\\\"".$_POST['io_in_iface_extra']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['iface']) and $_POST['iface'] == "wifi_supplicant"){
    $exec = "/bin/sed -i 's/iface_supplicant=.*/iface_supplicant=\\\"".$_POST['iface_supplicant']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST['domain'])) {
    $exec = "/bin/sed -i 's/dnsmasq_domain=.*/dnsmasq_domain=\\\"".$_POST['domain']."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/domain=.*/domain=".$_POST['domain']."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);
}

header('Location: ../page_config.php');

?>