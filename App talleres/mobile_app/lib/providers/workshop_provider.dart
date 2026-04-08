import 'package:flutter/foundation.dart';
import '../models/models.dart';

class WorkshopProvider with ChangeNotifier {
  List<dynamic> _workshops = [];
  bool _isLoading = false;

  List<dynamic> get workshops => _workshops;
  bool get isLoading => _isLoading;

  Future<void> searchWorkshops() async {
    _isLoading = true;
    notifyListeners();
    
    // TODO: Implementar búsqueda
    await Future.delayed(const Duration(seconds: 1));
    
    _isLoading = false;
    notifyListeners();
  }
}

class AppointmentProvider with ChangeNotifier {
  List<dynamic> _appointments = [];
  bool _isLoading = false;

  List<dynamic> get appointments => _appointments;
  bool get isLoading => _isLoading;

  Future<void> loadAppointments() async {
    _isLoading = true;
    notifyListeners();
    
    // TODO: Implementar carga de citas
    await Future.delayed(const Duration(seconds: 1));
    
    _isLoading = false;
    notifyListeners();
  }
}