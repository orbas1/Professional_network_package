import 'package:flutter/material.dart';
import 'src/ui/screens/network_screen.dart';

class MenuItem {
  final String route;
  final IconData icon;
  final String label;
  final WidgetBuilder builder;
  MenuItem({required this.route, required this.icon, required this.label, required this.builder});
}

final menuItems = <MenuItem>[
  MenuItem(
    route: '/network',
    icon: Icons.people,
    label: 'My Network',
    builder: (context) => const NetworkScreen(),
  ),
];
