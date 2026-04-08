import 'package:flutter/foundation.dart';

class AppointmentProvider with ChangeNotifier {
  List<dynamic> _appointments = [];
  bool _isLoading = false;

  List<dynamic> get appointments => _appointments;
  bool get isLoading => _isLoading;

  Future<void> loadAppointments() async {
    _isLoading = true;
    notifyListeners();
    
    await Future.delayed(const Duration(seconds: 1));
    
    _isLoading = false;
    notifyListeners();
  }
}