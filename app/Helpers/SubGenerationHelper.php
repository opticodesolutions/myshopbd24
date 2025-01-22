<?php

namespace App\Helpers;

use App\Models\Customer;

class SubGenerationHelper
{
    // Function to get users by refer_code and order them by joining date
    public static function getUsersByReferCode($referCode)
    {
        return Customer::where('refer_by', $referCode)
            ->orderBy('created_at', 'asc')  // Sort by joining date
            ->where('type', 'subscription_user')
            ->get();
    }

    public static function getLevelWiseUsers($referCode, $maxLevels = 12)
    {
        $levelUsers = [];
        $levelMaxUsers = [2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096]; // প্রতিটি লেভেলে প্রয়োজনীয় ইউজারের সংখ্যা
        $currentLevelUsers = [$referCode];  // রুট ইউজারের রেফার কোড

        $globalPool = [];  // সমস্ত ইউজারদের গ্লোবাল পুল

        for ($level = 0; $level < $maxLevels; $level++) {
            $fetchedUsers = []; // এই লেভেলের জন্য ফেচ করা ইউজারদের অস্থায়ী স্টোরেজ

            // এই লেভেলের জন্য ইউজার ফেচ করা
            foreach ($currentLevelUsers as $currentReferCode) {
                $usersAtLevel = self::getUsersByReferCode($currentReferCode); // এই ইউজারের রেফার করা ইউজার ফেচ করা
                $fetchedUsers = array_merge($fetchedUsers, $usersAtLevel->toArray());
            }

            // গ্লোবাল পুলে সমস্ত ইউজার যোগ করা
            $globalPool = array_merge($globalPool, $fetchedUsers);

            // গ্লোবাল পুলকে created_at অনুযায়ী সর্ট করা
            usort($globalPool, function ($a, $b) {
                return strtotime($a['created_at']) - strtotime($b['created_at']);
            });

            // এই লেভেল পূরণ করার জন্য প্রয়োজনীয় ইউজার নেয়া
            $levelUsers[$level] = array_splice($globalPool, 0, $levelMaxUsers[$level]);

            // যদি লেভেল পূর্ণ না হয়, তাহলে পরবর্তী লেভেল থেকে ইউজার আনা
            while (count($levelUsers[$level]) < $levelMaxUsers[$level] && !empty($globalPool)) {
                $needed = $levelMaxUsers[$level] - count($levelUsers[$level]);
                $additionalUsers = array_splice($globalPool, 0, $needed);
                $levelUsers[$level] = array_merge($levelUsers[$level], $additionalUsers);
            }

            // পরবর্তী লেভেলের জন্য রেফার কোড প্রস্তুত করা
            $currentLevelUsers = array_column($levelUsers[$level], 'refer_code');
        }

        // পুনরায় লেভেল পূরণ করা, যদি লেভেলের পরিমাণ কম থাকে
        for ($level = 0; $level < $maxLevels; $level++) {
            if (count($levelUsers[$level]) < $levelMaxUsers[$level]) {
                for ($nextLevel = $level + 1; $nextLevel < $maxLevels; $nextLevel++) {
                    if (isset($levelUsers[$nextLevel]) && !empty($levelUsers[$nextLevel])) {
                        $needed = $levelMaxUsers[$level] - count($levelUsers[$level]);
                        $surplusUsers = array_splice($levelUsers[$nextLevel], 0, $needed);
                        $levelUsers[$level] = array_merge($levelUsers[$level], $surplusUsers);

                        if (count($levelUsers[$level]) === $levelMaxUsers[$level]) {
                            break;
                        }
                    }
                }
            }
        }

        return $levelUsers;
    }



    public static function getTree($referCode, $currentLevel = 1, $maxLevel = 12)
    {
        // Stop recursion if the current level exceeds the maximum level
        if ($currentLevel > $maxLevel) {
            return null;
        }

        // Fetch the customer by refer code
        $customer = Customer::with('user')->where('refer_code', $referCode)->first();

        if (!$customer) {
            return null;
        }

        return [
            'customer' => $customer,
            'user_id' => $customer->user->id,
            'level' => $currentLevel,
        ];
    }

    public static function getAllChildUsersIdsForRoot($referCode, $maxLevel = 12)
    {
        $userIds = [];
        self::collectUserIdsByLevel($referCode, 1, $maxLevel, $userIds);
        return $userIds;
    }

    private static function collectUserIdsByLevel($referCode, $currentLevel, $maxLevel, &$userIds)
    {
        if ($currentLevel > $maxLevel) {
            return;
        }

        // Fetch the customer by refer code
        $customer = Customer::with('user')->where('refer_code', $referCode)->first();

        if (!$customer) {
            return;
        }

        // Add the user ID of the current node
        $userIds[] = $customer->user->id;

        // Fetch children customers referred by the current customer
        $children = Customer::where('refer_by', $referCode)->get();

        foreach ($children as $child) {
            self::collectUserIdsByLevel($child->refer_code, $currentLevel + 1, $maxLevel, $userIds);
        }
    }


    public static function getTotalUsersForRoot($referCode, $maxLevel = 12)
    {
        return self::countUsersInTree($referCode, 1, $maxLevel);
    }

    private static function countUsersInTree($referCode, $currentLevel, $maxLevel)
    {
        if ($currentLevel > $maxLevel) {
            return 0;
        }

        // Fetch the root customer
        $customer = Customer::where(
            'refer_code',
            $referCode
        )->first();

        if (!$customer) {
            return 0;
        }

        // Count children recursively
        $childCount = Customer::where(
            'refer_by',
            $referCode
        )->count();

        $totalCount = 1; // Count the current user

        // Recursively count all children
        $children = Customer::where('refer_by', $referCode)->get();
        foreach ($children as $child) {
            $totalCount += self::countUsersInTree($child->refer_code, $currentLevel + 1, $maxLevel);
        }

        return $totalCount;
    }
}
