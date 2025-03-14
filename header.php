<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include('./config.php'); ?>

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none">

<!-- Mirrored from kanakku.dreamstechnologies.com/html/template/dashboard.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Jan 2025 08:24:13 GMT -->

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Font family -->
	<style type="text/css">
		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 100;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 100;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 100;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);
			unicode-range: U+1F00-1FFF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 100;
			src: url(https://sarsspl.com/css/dash/esir/camp/assets/fonts/normal.woff2);
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 100;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0370-03FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 100;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 100;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 200;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0370-03FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 200;
			src: url(https://sarsspl.com/css/dash/esir/camp/assets/fonts/normal.woff2);
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 200;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 200;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 200;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);
			unicode-range: U+1F00-1FFF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 200;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 200;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 300;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);
			unicode-range: U+1F00-1FFF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 300;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0370-03FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 300;
			src: url(https://sarsspl.com/css/dash/esir/camp/assets/fonts/normal.woff2);
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 300;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 300;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 300;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 300;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 400;
			src: url(https://sarsspl.com/css/dash/esir/camp/assets/fonts/normal.woff2);
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 400;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 400;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 400;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0370-03FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 400;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 400;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);
			unicode-range: U+1F00-1FFF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 400;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 500;
			src: url(https://sarsspl.com/css/dash/esir/camp/assets/fonts/normal.woff2);
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 500;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);
			unicode-range: U+1F00-1FFF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 500;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 500;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 500;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 500;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 500;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0370-03FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 600;
			src: url(https://sarsspl.com/css/dash/esir/camp/assets/fonts/normal.woff2);
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 600;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 600;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 600;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0370-03FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 600;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);
			unicode-range: U+1F00-1FFF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 600;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 600;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 700;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 700;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);
			unicode-range: U+1F00-1FFF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 700;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 700;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 700;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 700;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0370-03FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 700;
			src: url(https://sarsspl.com/css/dash/esir/camp/assets/fonts/normal.woff2);
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 800;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 800;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0370-03FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 800;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 800;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 800;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 800;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);
			unicode-range: U+1F00-1FFF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 800;
			src: url(https://sarsspl.com/css/dash/esir/camp/assets/fonts/normal.woff2);
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 900;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0370-03FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 900;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 900;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 900;
			src: url(./assets/fonts/normal.woff2);
			unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 900;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);
			unicode-range: U+1F00-1FFF;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 900;
			src: url(https://sarsspl.com/css/dash/esir/camp/assets/fonts/normal.woff2);
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
			font-display: swap;
		}

		@font-face {
			font-family: Inter;
			font-style: normal;
			font-weight: 900;
			src: url(https://sarsspl.com/css/dash/esir/camp/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
			font-display: swap;
		}
	</style>

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="assets/plugins/feather/feather.css">

	<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

	<!-- Datepicker CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

	<!-- Datatables CSS -->
	<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">

	<!-- Layout JS -->
	<script src="assets/js/layout.js" type="9a1e0167d784f9247325ffe4-text/javascript"></script>
	<link rel="stylesheet" href="assets/plugins/alertify/alertify.min.css">

	<script src="./components/validation.js"></script>
	<script src="./assets/js/helper/main.js"></script>

</head>

<body>
	<style>
		.pagination {
			margin: 15px;
			justify-content: center;

		}
	</style>
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<div class="header header-one">
			<a href="dashboard.php" class="d-inline-flex d-sm-inline-flex align-items-center d-md-inline-flex d-lg-none align-items-center device-logo">
				<img src="./logo_camp.jpg" class="img-fluid logo2" alt="Logo" style="height: 40px;">
			</a>
			<div class="main-logo d-inline float-start d-lg-flex align-items-center d-none d-sm-none d-md-none">
				<div class="logo-white">
					<a href="dashboard.php">
						<img src="assets/img/logo-full-white.png" class="img-fluid logo-blue" alt="Logo">
					</a>
					<a href="dashboard.php">
						<img src="assets/img/logo-small-white.png" class="img-fluid logo-small" alt="Logo">
					</a>
				</div>
				<div class="logo-color">
					<a href="dashboard.php">
						<img src="./logo_camp.jpg" class="img-fluid logo-blue" alt="Logo" style="height: 40px;">
					</a>
					<a href="dashboard.php">
						<img src="assets/img/logo-small.png" class="img-fluid logo-small" alt="Logo">
					</a>
				</div>
			</div>
			<!-- Sidebar Toggle -->
			<a href="javascript:void(0);" id="toggle_btn">
				<span class="toggle-bars">
					<span class="bar-icons"></span>
					<span class="bar-icons"></span>
					<span class="bar-icons"></span>
					<span class="bar-icons"></span>
				</span>
			</a>
			<!-- /Sidebar Toggle -->

			<!-- Search -->
			<div class="top-nav-search">
				<form>
					<input type="text" class="form-control" placeholder="Search here">
					<button class="btn" type="submit"><img src="assets/img/icons/search.svg" alt="img"></button>
				</form>
			</div>
			<!-- /Search -->

			<!-- Mobile Menu Toggle -->
			<a class="mobile_btn" id="mobile_btn">
				<i class="fas fa-bars"></i>
			</a>
			<!-- /Mobile Menu Toggle -->

			<!-- Header Menu -->
			<ul class="nav nav-tabs user-menu">

				<!-- User Menu -->
				<li class="nav-item dropdown">
					<a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
						<span class="user-img">
							<img src="assets/img/profiles/avatar-07.jpg" alt="img" class="profilesidebar">
							<span class="animate-circle"></span>
						</span>
						<span class="user-content">
							<span class="user-details">Admin</span>
							<span class="user-name">John Smith</span>
						</span>
					</a>
					<div class="dropdown-menu menu-drop-user">
						<div class="profilemenu">
							<div class="subscription-menu">
								<ul>
									<li>
										<a class="dropdown-item" href="profile.html">Profile</a>
									</li>
									<li>
										<a class="dropdown-item" href="settings.html">Settings</a>
									</li>
								</ul>
							</div>
							<div class="subscription-logout">
								<ul>
									<li class="pb-0">
										<a class="dropdown-item" href="login.html">Log Out</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</li>
				<!-- /User Menu -->

			</ul>

			<!-- /Header Menu -->

		</div>
		<!-- /Header -->

		<?php include_once('./sidebar.php'); ?>

		<!-- /Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">