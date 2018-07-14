<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(12098, "mi_pendaftaran_pasien_php", $Language->MenuPhrase("12098", "MenuText"), "pendaftaran_pasien.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}pendaftaran_pasien.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(5577, "mi_home_php", $Language->MenuPhrase("5577", "MenuText"), "home.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}home.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(11207, "mi_t_advis_spm", $Language->MenuPhrase("11207", "MenuText"), "t_advis_spmlist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}t_advis_spm'), FALSE, FALSE);
$RootMenu->AddMenuItem(10381, "mi_vw_spm", $Language->MenuPhrase("10381", "MenuText"), "vw_spmlist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_spm'), FALSE, FALSE);
$RootMenu->AddMenuItem(9579, "mi_t_spd", $Language->MenuPhrase("9579", "MenuText"), "t_spdlist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}t_spd'), FALSE, FALSE);
$RootMenu->AddMenuItem(9580, "mi_m_kegiatan", $Language->MenuPhrase("9580", "MenuText"), "m_kegiatanlist.php?cmd=resetall", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}m_kegiatan'), FALSE, FALSE);
$RootMenu->AddMenuItem(9581, "mi_m_program", $Language->MenuPhrase("9581", "MenuText"), "m_programlist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}m_program'), FALSE, FALSE);
$RootMenu->AddMenuItem(9582, "mi_m_sub_kegiatan", $Language->MenuPhrase("9582", "MenuText"), "m_sub_kegiatanlist.php?cmd=resetall", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}m_sub_kegiatan'), FALSE, FALSE);
$RootMenu->AddMenuItem(6417, "mci_3ci_class3d22fa_fa2dflickr223e3c2fi3e_3cspan3eAntrian3c2fspan3e3cspan_class3d22pull2dright2dcontainer223e3csmall_class3d22label_pull2dright_bg2dgreen223eMenu_Baru3c2fsmall3e3c2fspan3e", $Language->MenuPhrase("6417", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(5645, "mi_tbnoantri", $Language->MenuPhrase("5645", "MenuText"), "tbnoantrilist.php", 6417, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}tbnoantri'), FALSE, FALSE);
$RootMenu->AddMenuItem(5644, "mi_tbantrianpoli", $Language->MenuPhrase("5644", "MenuText"), "tbantrianpolilist.php", 6417, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}tbantrianpoli'), FALSE, FALSE);
$RootMenu->AddMenuItem(5646, "mi_tbpanggil", $Language->MenuPhrase("5646", "MenuText"), "tbpanggillist.php", 6417, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}tbpanggil'), FALSE, FALSE);
$RootMenu->AddMenuItem(10380, "mci_3ci_class3d22fa_fa2drss2dsquare_text2dorange223e3c2fi3e_3cspan3eBendahara3c2fspan3e3cspan_class3d22pull2dright2dcontainer223e3c2fspan3e", $Language->MenuPhrase("10380", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(9575, "mci_3ci_class3d22fa_fa2drss2dsquare_text2dorange223e3c2fi3e_3cspan3ePengelolaan_SPJ3c2fspan3e3cspan_class3d22pull2dright2dcontainer223e3c2fspan3e", $Language->MenuPhrase("9575", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(8778, "mi_t_sbp", $Language->MenuPhrase("8778", "MenuText"), "t_sbplist.php", 9575, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}t_sbp'), FALSE, FALSE);
$RootMenu->AddMenuItem(9578, "mi_t_spj", $Language->MenuPhrase("9578", "MenuText"), "t_spjlist.php", 9575, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}t_spj'), FALSE, FALSE);
$RootMenu->AddMenuItem(7976, "mci_3ci_class3d22fa_fa2drss2dsquare_text2dorange223e3c2fi3e_3cspan3ePengelolaan_SPP3c2fspan3e3cspan_class3d22pull2dright2dcontainer223e3c2fspan3e", $Language->MenuPhrase("7976", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(7977, "mci_SPP_UP", $Language->MenuPhrase("7977", "MenuText"), "", 7976, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(5643, "mi_vw_spp_up_list", $Language->MenuPhrase("5643", "MenuText"), "vw_spp_up_listlist.php", 7977, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_spp_up_list'), FALSE, FALSE);
$RootMenu->AddMenuItem(7979, "mci_SPP_GU", $Language->MenuPhrase("7979", "MenuText"), "", 7976, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(5636, "mi_vw_spp_gu_list", $Language->MenuPhrase("5636", "MenuText"), "vw_spp_gu_listlist.php", 7979, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_spp_gu_list'), FALSE, FALSE);
$RootMenu->AddMenuItem(5638, "mi_vw_spp_gu_nihil_list", $Language->MenuPhrase("5638", "MenuText"), "vw_spp_gu_nihil_listlist.php", 7979, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_spp_gu_nihil_list'), FALSE, FALSE);
$RootMenu->AddMenuItem(7980, "mci_SPP_LS", $Language->MenuPhrase("7980", "MenuText"), "", 7976, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(5639, "mi_vw_spp_ls_gaji_list", $Language->MenuPhrase("5639", "MenuText"), "vw_spp_ls_gaji_listlist.php", 7980, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_spp_ls_gaji_list'), FALSE, FALSE);
$RootMenu->AddMenuItem(5640, "mi_vw_spp_ls_kontrak_list", $Language->MenuPhrase("5640", "MenuText"), "vw_spp_ls_kontrak_listlist.php", 7980, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_spp_ls_kontrak_list'), FALSE, FALSE);
$RootMenu->AddMenuItem(11194, "mci_SPP_PP", $Language->MenuPhrase("11194", "MenuText"), "", 7976, "", TRUE, FALSE, TRUE);
$RootMenu->AddMenuItem(11196, "mi_vw_spp_pengembalian_penerimaan", $Language->MenuPhrase("11196", "MenuText"), "vw_spp_pengembalian_penerimaanlist.php", 11194, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_spp_pengembalian_penerimaan'), FALSE, FALSE);
$RootMenu->AddMenuItem(7200, "mci_3ci_class3d22fa_fa2dcalendar_text2daqua223e3c2fi3e_3cspan3ePengaturan3c2fspan3e", $Language->MenuPhrase("7200", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(638, "mi_l_jenis_spp", $Language->MenuPhrase("638", "MenuText"), "l_jenis_spplist.php", 7200, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}l_jenis_spp'), FALSE, FALSE);
$RootMenu->AddMenuItem(5627, "mi_l_jenis_detail_spp", $Language->MenuPhrase("5627", "MenuText"), "l_jenis_detail_spplist.php", 7200, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}l_jenis_detail_spp'), FALSE, FALSE);
$RootMenu->AddMenuItem(9583, "mi_m_pejabat_keuangan", $Language->MenuPhrase("9583", "MenuText"), "m_pejabat_keuanganlist.php", 7200, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}m_pejabat_keuangan'), FALSE, FALSE);
$RootMenu->AddMenuItem(5616, "mi_Dasboard2_php", $Language->MenuPhrase("5616", "MenuText"), "Dasboard2.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}Dasboard2.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(5600, "mi_pd_tasks", $Language->MenuPhrase("5600", "MenuText"), "pd_taskslist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}pd_tasks'), FALSE, FALSE);
$RootMenu->AddMenuItem(5601, "mi_pd_analytics", $Language->MenuPhrase("5601", "MenuText"), "pd_analyticslist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}pd_analytics'), FALSE, FALSE);
$RootMenu->AddMenuItem(5603, "mi_audittrail", $Language->MenuPhrase("5603", "MenuText"), "audittraillist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}audittrail'), FALSE, FALSE);
$RootMenu->AddMenuItem(622, "mi_vw_bill_ranap", $Language->MenuPhrase("622", "MenuText"), "vw_bill_ranaplist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_bill_ranap'), FALSE, FALSE);
$RootMenu->AddMenuItem(1359, "mci_3ci_class3d27fa_fa2dgear273e3c2fi3e3cspan3e__Pengaturan3c2fspan3e_", $Language->MenuPhrase("1359", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(135, "mi_m_dokter_jaga_ranap", $Language->MenuPhrase("135", "MenuText"), "m_dokter_jaga_ranaplist.php", 1359, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}m_dokter_jaga_ranap'), FALSE, FALSE);
$RootMenu->AddMenuItem(618, "mi_t_admission_detail", $Language->MenuPhrase("618", "MenuText"), "t_admission_detaillist.php", 1359, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}t_admission_detail'), FALSE, FALSE);
$RootMenu->AddMenuItem(1360, "mci_3ci_class3d27fa_fa2ddatabase273e3c2fi3e_3cspan3e_Data3c2fspan3e_", $Language->MenuPhrase("1360", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(682, "mi_m_data_tarif", $Language->MenuPhrase("682", "MenuText"), "m_data_tariflist.php", 1360, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}m_data_tarif'), FALSE, FALSE);
$RootMenu->AddMenuItem(683, "mi_vw_bill_ranap_data_tarif_tindakan", $Language->MenuPhrase("683", "MenuText"), "vw_bill_ranap_data_tarif_tindakanlist.php", 1360, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_bill_ranap_data_tarif_tindakan'), FALSE, FALSE);
$RootMenu->AddMenuItem(3477, "mci_3ci_class3d27fa_fa2dreorder273e3c2fi3e_3cspan3e_Order3c2fspan3e_", $Language->MenuPhrase("3477", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(2782, "mci_3ci_class3d27fa__fa2dfile2dtext2do273e3c2fi3e_3cspan3e_Pendaftaran3c2fspan3e_", $Language->MenuPhrase("2782", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(9590, "mi_t_pendaftaran", $Language->MenuPhrase("9590", "MenuText"), "t_pendaftaranlist.php", 2782, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}t_pendaftaran'), FALSE, FALSE);
$RootMenu->AddMenuItem(246, "mi_t_orderadmission", $Language->MenuPhrase("246", "MenuText"), "t_orderadmissionlist.php", 2782, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}t_orderadmission'), FALSE, FALSE);
$RootMenu->AddMenuItem(654, "mi_userlevelpermissions", $Language->MenuPhrase("654", "MenuText"), "userlevelpermissionslist.php", -1, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE, FALSE);
$RootMenu->AddMenuItem(655, "mi_userlevels", $Language->MenuPhrase("655", "MenuText"), "userlevelslist.php", -1, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE, FALSE);
$RootMenu->AddMenuItem(4175, "mci_3ci_class3d27fa_fa2dusers273e3c2fi3e_3cspan3e_Pasien3c2fspan3e_", $Language->MenuPhrase("4175", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(448, "mi_vw_list_pasien_rawat_jalan", $Language->MenuPhrase("448", "MenuText"), "vw_list_pasien_rawat_jalanlist.php", 4175, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_list_pasien_rawat_jalan'), FALSE, FALSE);
$RootMenu->AddMenuItem(161, "mi_m_pasien", $Language->MenuPhrase("161", "MenuText"), "m_pasienlist.php", 4175, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}m_pasien'), FALSE, FALSE);
$RootMenu->AddMenuItem(211, "mi_t_admission", $Language->MenuPhrase("211", "MenuText"), "t_admissionlist.php", 4175, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}t_admission'), FALSE, FALSE);
$RootMenu->AddMenuItem(171, "mi_m_ruang", $Language->MenuPhrase("171", "MenuText"), "m_ruanglist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}m_ruang'), FALSE, FALSE);
$RootMenu->AddMenuItem(2099, "mci_3ci_class3d22fa_fa2drss2dsquare_text2dorange223e3c2fi3e_3cspan3eSEP_Rajal3c2fspan3e3cspan_class3d22pull2dright2dcontainer223e3csmall_class3d22label_pull2dright_bg2dgreen223enew3c2fsmall3e3c2fspan3e", $Language->MenuPhrase("2099", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(408, "mi_vw_bridging_sep_by_no_kartu", $Language->MenuPhrase("408", "MenuText"), "vw_bridging_sep_by_no_kartulist.php", 2099, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_bridging_sep_by_no_kartu'), FALSE, FALSE);
$RootMenu->AddMenuItem(409, "mi_vw_bridging_sep_by_no_rujukan", $Language->MenuPhrase("409", "MenuText"), "vw_bridging_sep_by_no_rujukanlist.php", 2099, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_bridging_sep_by_no_rujukan'), FALSE, FALSE);
$RootMenu->AddMenuItem(453, "mi_vw_lookup_dokter_poli", $Language->MenuPhrase("453", "MenuText"), "vw_lookup_dokter_polilist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_lookup_dokter_poli'), FALSE, FALSE);
$RootMenu->AddMenuItem(4889, "mci_3ci_class3d27fa_fa2dpie2dchart273e3c2fi3e3cspan3e__Laporan3c2fspan3e_", $Language->MenuPhrase("4889", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(466, "mi_vw_sensus_harian_rawat_jalan", $Language->MenuPhrase("466", "MenuText"), "vw_sensus_harian_rawat_jalanlist.php", 4889, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_sensus_harian_rawat_jalan'), FALSE, FALSE);
$RootMenu->AddMenuItem(5572, "mci_3ci_class3d27fa_fa2dfile2dcode2do273e3c2fi3e_3cspan3e_SEP_Ranap3c2fspan3e_", $Language->MenuPhrase("5572", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(468, "mi_vw_sep_rawat_inap_by_noka", $Language->MenuPhrase("468", "MenuText"), "vw_sep_rawat_inap_by_nokalist.php", 5572, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}vw_sep_rawat_inap_by_noka'), FALSE, FALSE);
$RootMenu->AddMenuItem(5598, "mi_training", $Language->MenuPhrase("5598", "MenuText"), "traininglist.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}training'), FALSE, FALSE);
$RootMenu->AddMenuItem(5573, "mi_chart1_php", $Language->MenuPhrase("5573", "MenuText"), "chart1.php", -1, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}chart1.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(7198, "mci_3ci_class3d22fa_fa2dbar2dchart_text2dgreen223e3c2fi3e_3cspan3ePejabat3c2fspan3e", $Language->MenuPhrase("7198", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(6418, "mi_data_kontrak", $Language->MenuPhrase("6418", "MenuText"), "data_kontraklist.php", 7198, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}data_kontrak'), FALSE, FALSE);
$RootMenu->AddMenuItem(12031, "mci_3ci_class_3d_27fa_fa2dlist_text2dyellow273e3c2fi3e_3cspan3eRekening_Akun3c2fspan3e", $Language->MenuPhrase("12031", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(12033, "mi_keu_akun1", $Language->MenuPhrase("12033", "MenuText"), "keu_akun1list.php", 12031, "", AllowListMenu('{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}keu_akun1'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", "<i class='fa fa-key'></i><span>" . $Language->Phrase("ChangePwd") . "</span>", "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", "<i class='fa fa-sign-out'></i><span>" . $Language->Phrase("Logout") . "</span>", "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", "<i class='fa fa-sign-in'></i><span>" . $Language->Phrase("Login") . "</span>", "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
