import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../state/network_state.dart';

class NetworkScreen extends StatelessWidget {
  const NetworkScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final state = context.watch<NetworkState>();
    return Scaffold(
      appBar: AppBar(title: const Text('My Network')),
      body: state.loading
          ? const Center(child: CircularProgressIndicator())
          : state.error != null
              ? Center(child: Text(state.error!))
              : ListView.builder(
                  itemCount: state.connections.length,
                  itemBuilder: (context, index) {
                    final c = state.connections[index];
                    return ListTile(
                      title: Text('Connection #${c.connectionId}'),
                      subtitle: Text('Degree ${c.degree}'),
                    );
                  },
                ),
    );
  }
}
