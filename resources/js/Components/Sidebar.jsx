import React from "react";
import { Link } from "@inertiajs/react";
import NavItem from "./NavItem";

const Sidebar = () => {
    // ✅ Tambahkan function ini
    const hasAnyPermission = (permissions) => {
        if (!auth || !auth.permissions) return false;
        return permissions.some((p) => auth.permissions.includes(p));
    };

    return (
        <nav
            className="navbar sidebar navbar-expand-xl navbar-light bg-dark"
            style={{ overflowY: "auto" }}
        >
            <div className="p-3 d-flex align-items-center">
                <Link className="navbar-brand" href="/">
                    <span className="mb-0 navbar-brand-item h5 text-primary">
                        EasyPOS
                    </span>
                </Link>
            </div>

            <div
                className="flex-row offcanvas offcanvas-start custom-scrollbar h-100"
                data-bs-backdrop="true"
                tabIndex="-1"
                id="offcanvasSidebar"
            >
                <div className="offcanvas-body sidebar-content d-flex flex-column bg-dark">
                    <ul className="navbar-nav flex-column" id="navbar-sidebar">
                        <li className="mt-3 mb-1 nav-item text-muted">
                            Dashboard
                        </li>

                        {/* {hasAnyPermission(["dashboard.index"]) && (
                            <NavItem
                                href="/admin/dashboard"
                                icon="bi-speedometer"
                                label="Dashboard"
                            />
                        )} */}

                        {/* sementara */}
                        <NavItem
                            href="/admin/dashboard"
                            icon="bi-speedometer"
                            label="Dashboard"
                        />

                        <li className="nav-item mt-3 mb-1 text-muted">
                            User Management
                        </li>

                        {hasAnyPermission(["roles.index"]) && (
                            <NavItem
                                href="/admin/roles"
                                icon="bi-shield-lock"
                                label="Roles"
                            />
                        )}
                    </ul>
                </div>
            </div>
        </nav>
    );
};

export default Sidebar;
