// import { usePage } from '@inertiajs/react';

// export default function hasAnyPermission(permissions) {
//     const { auth } = usePage().props;
//     const allPermissions = auth.permissions;

//     return permissions.some(permission => allPermissions[permission]);
// }

import { usePage } from "@inertiajs/react";

// export default function hasAnyPermission(permissions) {
//     const { auth } = usePage().props;
//     const allPermissions = auth?.permissions || [];

//     return permissions.some((permission) =>
//         allPermissions.includes(permission),
//     );
// }

export default function hasAnyPermission(permissions) {
    const { auth } = usePage().props;
    const allPermissions = auth.permissions || [];

    return permissions.some((permission) =>
        allPermissions.includes(permission),
    );
}
