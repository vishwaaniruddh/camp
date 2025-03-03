<!-- Sidebar -->
<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul class="sidebar-vertical">
				<!-- Main -->
				<li class="menu-title"><span>Main</span></li>
				<li class="submenu">
					<a href="dashboard.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
				</li>

				<!-- Super Admin -->
				<li class="menu-title"><span>Super Admin</span></li>
				<li class="submenu">
					<a href="javascript:void(0);"><i class="fa fa-user-shield"></i> <span>Admin Management</span> <span
							class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="users.php"><i class="fe fe-user"></i> Users</a></li>
						<li><a href="roles-permission.php"><i class="fe fe-lock"></i> Roles & Permissions</a></li>
						<li><a href="delete-account-request.php"><i class="fe fe-trash"></i> Delete Account Requests</a>
						</li>
					</ul>
				</li>
				<li><a href="vendors.php"><i class="fe fe-truck"></i> <span>Vendors</span></a></li>

				<li class="submenu">
					<a href="#"><i class="fe fe-package"></i> <span>Products & Services</span> <span
							class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="product-list.php"><i class="fe fe-list"></i> Product List</a></li>
						<li><a href="category.php"><i class="fe fe-tag"></i> Categories</a></li>
						<li><a href="units.php"><i class="fe fe-box"></i> Units</a></li>
					</ul>
				</li>
				<li><a href="couriers.php"><i class="fe fe-truck"></i> <span>Courier</span></a></li>

				<li class="menu-title"><span>Inventory Management</span></li>
				<li class="submenu">
					<a href="#"><i class="fe fe-box"></i> <span>Inventory</span> <span
							class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="inventory.php"><i class="fe fe-box"></i> Stock Overview</a></li>
						<li><a href="incoming_request.php"><i class="fe fe-file-text"></i> Material Requests</a></li>
						<li><a href="stock-adjustments.php"><i class="fe fe-refresh-cw"></i> Stock Adjustments</a></li>
						<li><a href="stock-transfers.php"><i class="fe fe-truck"></i> Stock Transfers</a></li>
						<li><a href="warehouses.php"><i class="fe fe-home"></i> Warehouse Management</a></li>
						<li><a href="spare-parts.php"><i class="fe fe-file-text"></i> Spare Parts Catalog</a></li>
						<li><a href="stock-expiry.php"><i class="fe fe-clock"></i> Stock Expiry & Alerts</a></li>
					</ul>
				</li>

				<!-- Dispatch & Tracking -->
				<li class="submenu">
					<a href="#"><i class="fe fe-truck"></i> <span>Dispatch & Tracking</span> <span
							class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="dispatch-orders.php"><i class="fe fe-send"></i> Dispatch Orders</a></li>
						<li><a href="couriers.php"><i class="fe fe-box"></i> Courier Tracking</a></li>
						<li><a href="live-tracking.php"><i class="fe fe-map"></i> Live GPS Tracking</a></li>
						<li><a href="delivery-confirmations.php"><i class="fe fe-check-circle"></i> Delivery
								Confirmations</a></li>
					</ul>
				</li>

				<!-- Installation & Service Logs -->
				<li class="submenu">
					<a href="#"><i class="fe fe-list"></i> <span>Installation & Service Logs</span> <span
							class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="new-installations.php"><i class="fe fe-plus-circle"></i> New Installations</a></li>
						<li><a href="service-history.php"><i class="fe fe-settings"></i> Service History</a></li>
						<li><a href="return-management.php"><i class="fe fe-refresh-ccw"></i> Defective Part Returns</a>
						</li>
						<li><a href="engineer-logs.php"><i class="fe fe-user-check"></i> Engineer Work Logs</a></li>
					</ul>
				</li>

				<!-- Purchases -->
				<li class="menu-title"><span>Purchases</span></li>
				<li><a href="add-purchase-orders.php"><i class="fe fe-plus-circle"></i> <span>Add Purchase
							Order</span></a></li>
				<li><a href="purchase-orders.php"><i class="fe fe-list"></i> <span>View Purchase Orders</span></a></li>
				<li><a href="#"><i class="fe fe-file-text"></i> <span>Debit Notes (Coming Soon)</span></a></li>

				<!-- Reports -->
				<li class="menu-title"><span>Reports (Coming Soon)</span></li>
				<li class="submenu">
					<a href="#"><i class="fe fe-bar-chart"></i> <span>Reports</span> <span
							class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Expense Report</span> </a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Purchase Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Purchase Return Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Sales Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Sales Return Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Quotation Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Payment Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Stock Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Low Stock Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Income Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Tax Report</span></a></li>
						<li><a href="#"><i class="fe fe-file-text"></i> <span>Profit & Loss</span></a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let currentPage = window.location.pathname.split("/").pop(); // Get the current page filename
    let menuItems = document.querySelectorAll("#sidebar-menu ul li a"); 

    menuItems.forEach(item => {
        if (item.getAttribute("href") === currentPage) {
            item.classList.add("active"); // Highlight active menu item
            let parentUl = item.closest("ul");
            if (parentUl) {
                parentUl.style.display = "block"; // Keep parent submenu open
                let parentLi = parentUl.closest(".submenu");
                if (parentLi) {
                    parentLi.classList.add("active"); // Highlight the submenu title
                }
            }
        }
    });
});
</script>