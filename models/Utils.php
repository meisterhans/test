<?php

namespace app\models;

class Utils {

    public function formatQuota($quota) {
        if($quota >= 1024) {
            $quota = $quota / 1024;
            if($quota >= 1024) {
                $quota = $quota / 1024;
                return round($quota, 1) . " TB";
            }

            return round($quota, 1) . " GB";
        }

        return $quota . " MB";
    }

    public function quotaToMB($quota_type, $quota) {
        if($quota_type == Companies::TB) {
            $quota = $quota * 1024;
            $quota_type = Companies::GB;
        }

        if($quota_type == Companies::GB) {
            $quota = $quota * 1024;
        }

        return $quota;
    }
}