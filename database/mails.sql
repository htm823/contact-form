-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2026 年 7 月 09 日 13:29
-- サーバのバージョン： 5.7.39
-- PHP のバージョン: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `form_study`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `mails`
--

CREATE TABLE `mails` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(100) NOT NULL COMMENT '名前',
  `kana` varchar(100) NOT NULL COMMENT 'フリガナ',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `tel` varchar(20) NOT NULL COMMENT '電話番号',
  `postal_code` varchar(10) NOT NULL COMMENT '郵便番号',
  `address` varchar(255) NOT NULL COMMENT '住所',
  `gender` varchar(10) NOT NULL COMMENT '性別',
  `content` varchar(20) NOT NULL COMMENT '応募内容',
  `question` text NOT NULL COMMENT '質問',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'ステータス',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `mails`
--

INSERT INTO `mails` (`id`, `name`, `kana`, `email`, `tel`, `postal_code`, `address`, `gender`, `content`, `question`, `status`, `created_at`, `updated_at`) VALUES
(1, '山田花子', 'ヤマダハナコ', 'hanako@gmail.com', '090-1010-2020', '120-0022', '東京都足立区柳原2-10', '女性', 'フルタイム', '書類のフォーマットが知りたい', 0, '2026-07-09 03:55:29', '2026-07-09 03:55:29'),
(2, '山田佳菜子', 'ヤマダカナコ', 'hana@gmail.com', '090-1010-2020', '130-0011', '東京都墨田区石原3-15', '女性', 'インターンシップ', '説明会はいつ開催されますか', 1, '2026-07-09 03:56:52', '2026-07-09 03:56:52'),
(3, '桜木翔平', 'サクラギショウヘイ', 'show-hey@gmail.com', '090-2020-3030', '130-0023', '東京都墨田区立川4-4', '男性', 'フルタイム', '面接はオンラインでも可能でしょうか', 0, '2026-07-09 03:58:16', '2026-07-09 03:58:16'),
(4, '佐藤三郎', 'サトウサブロウ', 'sabrow@gmail.com', '090-2020-3030', '526-0023', '滋賀県長浜市三ツ矢町', '男性', 'パートタイム', '副業は可能でしょうか', 1, '2026-07-09 03:59:29', '2026-07-09 03:59:29'),
(5, '斎藤桜', 'サイトウサクラ', 'blossom@gmail.com', '080-2929-3030', '521-0022', '滋賀県米原市樋口', '女性', 'パートタイム', '週10時間〜可能でしょうか', 0, '2026-07-09 04:00:42', '2026-07-09 04:00:42'),
(6, '中村次郎', 'ナカムラジロウ', 'rororow@gmail.com', '070-2202-0101', '120-0022', '東京都足立区柳原', '男性', 'インターンシップ', '説明会の持ち物を知りたい', 1, '2026-07-09 04:01:58', '2026-07-09 04:01:58'),
(7, '斎藤一郎', 'サイトウイチロウ', 'sugerow@gmail.com', '090-2020-3030', '401-0022', '山梨県大月市初狩町中初狩', '男性', 'フルタイム', 'フレックス勤務は可能でしょうか', 0, '2026-07-09 04:03:12', '2026-07-09 04:03:12');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
