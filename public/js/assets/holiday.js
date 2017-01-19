HolidayDateTime = {
	dateFormat: 'YYYY-MM-DD',
	selectedDate: '',
    /** 祝日一覧 */
    // 種別：
    //   fixed=日付固定
    //   happy=指定の週の月曜日
    //   spring=春分の日専用
    //   autumn=秋分の日専用
    holidays : [
        // 種別, 月, 日or週, 開始年, 終了年, 祝日名
        ['fixed',   1,  1, 1949, 9999, '元日'],
        ['fixed',   1, 15, 1949, 1999, '成人の日'],
        ['happy',   1,  2, 2000, 9999, '成人の日'],
        ['fixed',   2, 11, 1967, 9999, '建国記念の日'],
        ['spring',  3,  0, 1949, 9999, '春分の日'],
        ['fixed',   4, 29, 1949, 1989, '天皇誕生日'],
        ['fixed',   4, 29, 1990, 2006, 'みどりの日'],
        ['fixed',   4, 29, 2007, 9999, '昭和の日'],
        ['fixed',   5,  3, 1949, 9999, '憲法記念日'],
        ['fixed',   5,  4, 1988, 2006, '国民の休日'],
        ['fixed',   5,  4, 2007, 9999, 'みどりの日'],
        ['fixed',   5,  5, 1949, 9999, 'こどもの日'],
        ['happy',   7,  3, 2003, 9999, '海の日'],
        ['fixed',   7, 20, 1996, 2002, '海の日'],
        ['fixed',   8, 11, 2016, 9999, '山の日'],
        ['autumn',  9,  0, 1948, 9999, '秋分の日'],
        ['fixed',   9, 15, 1966, 2002, '敬老の日'],
        ['happy',   9,  3, 2003, 9999, '敬老の日'],
        ['fixed',  10, 10, 1966, 1999, '体育の日'],
        ['happy',  10,  2, 2000, 9999, '体育の日'],
        ['fixed',  11,  3, 1948, 9999, '文化の日'],
        ['fixed',  11, 23, 1948, 9999, '勤労感謝の日'],
        ['fixed',  12, 23, 1989, 9999, '天皇誕生日'],
        //以下、1年だけの祝日
        ['fixed',   4, 10, 1959, 1959, '皇太子明仁親王の結婚の儀'],
        ['fixed',   2, 24, 1989, 1989, '昭和天皇の大喪の礼'],
        ['fixed',  11, 12, 1990, 1990, '即位礼正殿の儀'],
        ['fixed',   6,  9, 1993, 1993, '皇太子徳仁親王の結婚の儀'],
    ],

   setDate: function(selectedDate){
	   this.selectedDate = moment(selectedDate, this.dateFormat);
   },
   /**
    * 祝日を取得
    */
   holiday: function()
   {
       // 設定された休日チェック
       $result = this.checkHoliday();
       if ($result !== false) return $result;

       // 振替休日チェック
       $result = this.checkTransferHoliday();
       if ($result !== false) return $result;

       // 国民の休日チェック
       $result = this.checkNationalHoliday();

       return $result;
   },

    /**
     * 設定された休日のみチェック
     * 国民の休日と振替休日はチェックしない
     */
    checkHoliday: function()
    {
        $result = false;

        // 全ての祝日を判定
        jQuery.each(this.holidays, function(index, $holiday) {
        	$method = $holiday[0];
        	$month 	= $holiday[1];
        	$day 	= $holiday[2];
        	$start 	= $holiday[3];
        	$end 	= $holiday[4];
        	$name 	= $holiday[5];
        	
            $method += 'Holiday';
            $result = HolidayDateTime[$method]($month, $day, $start, $end, $name);
            if ($result) {
                return false;
            }
        })
        return $result;
    },

    checkTransferHoliday: function()
    {
        // 施行日チェック
    	var $d = moment('1973-04-12', this.dateFormat);
    	
        if (this.selectedDate.isBefore($d)) return false;

        // 当日が祝日の場合はfalse
        if (this.checkHoliday()) return false;

        $num = (this.get('year') <= 2006) ? 1 : 7; //改正法なら最大7日間遡る

        $d = cloneObject(this);
        $d.selectedDate.subtract(1, 'days');
        $isTransfer = false;
        for ($i = 0 ; $i < $num ; $i++) {
            if ($d.checkHoliday()) {
                // 祝日かつ日曜ならば振替休日
                if ($d.get('dayOfWeek') == 0) {
                    $isTransfer = true;
                    break;
                }
                $d.selectedDate.subtract(1, 'days');
            } else {
                break;
            }
        }
        return $isTransfer ? '振替休日' : false;
    },
    
    /**
     * 国民の休日かどうかチェック
     */
    checkNationalHoliday: function ()
    {
        // 施行日チェック
		var $d = moment('1973-04-12', this.dateFormat);
        if (this.selectedDate.isBefore($d)) return false;

        $before = cloneObject(this);
        $before.selectedDate.subtract(1, 'days');
        
        if ($before.checkHoliday() === false) return false;

        $after = cloneObject(this);
        $after.selectedDate.add(1, 'days');
        if ($after.checkHoliday() === false) return false;

        return '国民の休日';
    },

    /**
     * 固定祝日かどうか
     */
    fixedHoliday: function($month, $day, $start, $end, $name)
    {
        if (this.isWithinYear($start, $end) === false) return false;
        if (this.get('month') != $month) return false;

        if (this.get('day') != $day) return false;
        return $name;
    },

   /**
    * ハッピーマンデー
    */
    happyHoliday: function($month, $week, $start, $end, $name)
   {
       if (this.isWithinYear($start, $end) === false) return false;
       if (this.get('month') != $month) return false;

       // 第*月曜日の日付を求める
       $w = 1; // 月曜日固定
       $d1 = cloneObject(this);
       $d1.setDate(this.selectedDate.format('YYYY-MM-01'));
       $w1 = $d1.get('dayOfWeek');
       $day  = $w - $w1 < 0 ? 7 + $w - $w1 : $w - $w1;
       $day++;
       $day = $day + 7 * ($week - 1);

       if (this.get('day') != $day) return false;
       return $name;
   },

    /**
     * 春分の日
     */
    springHoliday: function($month, $dummy, $start, $end, $name)
    {
        if (this.isWithinYear($start, $end) === false) return false;
        if (this.get('month') != $month) return false;

        $year = this.get('year');
        $day = Math.floor(20.8431 + 0.242194 * ($year - 1980) - Math.floor(($year - 1980) / 4));

        if (this.get('day') != $day) return false;
        return $name;
    },

    /**
     * 秋分の日
     */
   autumnHoliday: function($month, $dummy, $start, $end, $name)
    {
        if (this.isWithinYear($start, $end) === false) return false;
        if (this.get('month') != $month) return false;

        $year = this.get('year');
        $day = Math.floor(23.2488 + 0.242194 * ($year - 1980) - Math.floor(($year - 1980) / 4));

        if (this.get('day') != $day) return false;
        return $name;
    },

    /**
     * 年が祝日適用範囲内であるか
     */
    isWithinYear: function($start, $end)
    {
        if (this.get('year') < $start || $end < this.get('year')) {
            return false;
        }
        return true;
    },

    // 以下Carbonを継承している場合は削除すべし
    get: function($name)
    {
    	$formats = {
            'year' : 'YYYY',
            'month' : 'MM',
            'day' : 'DD',
            'hour' : 'H',
            'minute' : 'mm',
            'second' : 's',
            'micro' : 'ms',
            'dayOfWeek' : 'E',
            'dayOfYear' : 'DDD',
            'weekOfYear' : 'W',
            'daysInMonth' : 'DD',
            'timestamp' : 'x',
    	}
        return parseInt(this.selectedDate.format($formats[$name]));
    }
}