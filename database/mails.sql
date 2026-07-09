-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2026 年 7 月 09 日 07:38
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
(1, '佐藤時子', 'サトウトキコ', 'example@gmail.com', '090-8719-1039', '131-0032', '東京都墨田区東向島', '女性', 'part-time', '書類のフォーマットが知りたい', 0, '2026-07-08 20:33:54', '2026-07-08 20:33:54'),
(2, '山田花子', 'ヤマダハナコ', 'example@gmail.com', '090-1298-3409', '130-0011', '東京都墨田区石原', '女性', 'internship', 'インターンシップの募集はありますか', 0, '2026-07-08 20:35:00', '2026-07-08 20:35:00'),
(3, '山村花子', 'ヤマムラハナコ', 'example@gmail.com', '090-9090-0909', '131-0033', '東京都墨田区向島', '女性', 'full-time', 'フレックス勤務は可能でしょうか', 1, '2026-07-08 21:20:24', '2026-07-08 21:20:24'),
(4, '山村美佐子', 'ヤマムラミサコ', 'example@gmail.com', '090-6578-4839', '130-0026', '東京都墨田区両国', '女性', 'part-time', '週20時間〜可能でしょうか', 0, '2026-07-08 21:22:22', '2026-07-08 21:22:22'),
(5, '山中孝雄', 'ヤマナカタカオ', 'example@gmail.com', '090-7594-0923', '130-0023', '東京都墨田区立川', '男性', 'full-time', 'リモート勤務は可能でしょうか', 1, '2026-07-08 21:23:36', '2026-07-08 21:23:36'),
(6, '野村康二', 'ノムラコウジ', 'example@gmail.com', '090-7584-1039', '130-0021', '東京都墨田区緑', '男性', 'part-time', '提出書類のフォーマットが知りたい', 0, '2026-07-08 21:25:16', '2026-07-08 21:25:16'),
(7, '山中貴子', 'ヤマナカタカコ', 'example@gmail.com', '090-8109-2034', '340-0022', '埼玉県草加市瀬崎', '女性', 'internship', '応募はいつから開始されますか', 0, '2026-07-08 22:37:00', '2026-07-08 22:37:00');

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
