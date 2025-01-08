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
        $levelMaxUsers = [1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048]; // Max users per level
        $currentLevelUsers = [$referCode];  // Starting point (root user refer_code)

        for ($level = 0; $level < $maxLevels; $level++) {
            $levelUsers[$level] = []; // Initialize this level's users
            $fetchedUsers = []; // Temporary storage for fetched users at this level

            foreach ($currentLevelUsers as $currentReferCode) {
                $usersAtLevel = self::getUsersByReferCode($currentReferCode); // Fetch users referred by current user
                $fetchedUsers = array_merge($fetchedUsers, $usersAtLevel->toArray());
            }

            // Sort fetched users by created_at
            usort($fetchedUsers, function ($a, $b) {
                return strtotime($a['created_at']) - strtotime($b['created_at']);
            });

            // Add users up to the maximum allowed for this level
            $levelUsers[$level] = array_slice($fetchedUsers, 0, $levelMaxUsers[$level]);

            // Prepare the refer codes for the next level
            $currentLevelUsers = array_column($levelUsers[$level], 'refer_code');
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

    public static function getAllChildUsersIdsForRoot($referCode, $maxLevel = 12) {
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
        $customer = Customer::where('refer_code',
            $referCode
        )->first();

        if (!$customer) {
            return 0;
        }

        // Count children recursively
        $childCount = Customer::where('refer_by',
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